<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Auth;
use Mockery\CountValidator\Exception;
use Validator;
use App\User;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use App\Regularseat;
use App\Lanparty;
use App\Seat;
use App\Coin;
use App\Code;

class LanpartyController extends Controller
{
	/**
	 * location view
	 */
	public function location() {
        $pictures = [
            'halle1.jpg',
            'halle2.jpg',
            'schlafplatz.jpg'
        ];

        return view('lanparty.location')
            ->with('pictures', $pictures);
    }

	/**
	 * get reservation view
	 */
	public function reservation() {
		$reservedseats = null;
        $usercanreserveseats = 0;

        //get next lanparty
		$lanparty = Lanparty::getNextLan();
		$user = (Auth::check()) ? Auth::user() : null;
		
		if ($lanparty instanceof Lanparty) {
			$reservedseats = $lanparty->getReservedSeats();
            $usercanreserveseats = (!is_null($user) && $user->seats()->where('lanparty_id', $lanparty->id)->get()->count() < $user->maxseats) ? ($user->maxseats - $user->seats()->where('lanparty_id', $lanparty->id)->get()->count()) : 0;
		}

		return view('lanparty.reservation')
			->with('lanparty', $lanparty)
			->with('user', $user)
			->with('usercanreserveseats', $usercanreserveseats)
			->with('reservedseats', $reservedseats);
	}
	
	/**
	 * post reservation
	 */
	public function reservationPost(Request $request) {
		if (!Auth::check()) {
			return redirect(route('home'));
		}
		
		$now = new Carbon();
		
		if (!empty($request->seatnumber) && !empty($request->lanparty)) {
			//check if lanparty reservation time is open
			$lanparty = Lanparty::findOrFail($request->lanparty);
			if ($lanparty instanceof \App\Lanparty) {
				if ($lanparty->registrationstart < $now && $lanparty->registrationend > $now) {
					//check if seat is free
					$seats = $lanparty->getReservedSeats();
					if (!isset($seats[$request->seatnumber])) {
						$seat = new Seat();
						$seat->user_id = Auth::user()->id;
						$seat->seatnumber = $request->seatnumber;
						$seat->status = 1;
						$seat->marked_at = $now;
						$lanparty->seats()->save($seat);
						
						$request->session()->flash('alert-success', 'Die Reservierung wurde erfolgreich durchgeführt.');
						return redirect(route('lanparty.reservation'));
					}
					else {
						$request->session()->flash('alert-danger', 'Die Reservierung konnte nicht gespeichert werden.');
						return redirect(route('lanparty.reservation'));
					}
				}
				else {
					$request->session()->flash('alert-danger', 'Zur Zeit kann leider keine Reservierung durchgeführt werden.');
					return redirect(route('lanparty.reservation'));
				}
			}
			else {
				$request->session()->flash('alert-danger', 'Die Lanparty wurde nicht gefunden.');
				return redirect(route('lanparty.reservation'));
			}
		}
		else {
			$request->session()->flash('alert-danger', 'Fehler bei der Reservierung.');
			return redirect(route('lanparty.reservation'));
		}
	}
	
	/**
	 * delete a reservation
	 * 
	 * @param Request $request
	 */
	public function reservationDelete(Request $request) {
		if (!Auth::check()) {
			return redirect(route('home'));
		}
		
		$seat = Seat::findOrFail($request->id);
		if ($seat->user_id == $request->user_id) {
			$seat->delete();
		}
		
		$request->session()->flash('alert-success', 'Die Reservierung wurde storniert.');
		return redirect(route('lanparty.reservation'));
	}
	
	/**
	 * reservation code post function
	 *
	 * @param Request $request
	 */
	public function reservationCode(Request $request) {
		if (!Auth::check()) {
			return redirect(route('home'));
		}
		
		$now = new Carbon();
		$user = (isset($request->user) && !empty($request->user)) ? Auth::user() : null;
		$seat = (isset($request->seat) && !empty($request->seat)) ? Seat::findOrFail($request->seat) : null;
		$lanparty = (isset($request->lanparty) && !empty($request->lanparty)) ? Lanparty::findOrFail($request->lanparty) : null;
		
		if (!empty($request->code) && !is_null($user) && !is_null($seat) && !is_null($lanparty)) {
			
			//check code eq. AAA-AA-AAA
			if (preg_match('/[A-Z0-9]{3}\-[A-Z0-9]{2}\-[A-Z0-9]{3}/', $request->code)) {
				//check if code wasnt used before and is active
				$code = Code::findByCode($request->code);
				
				if ($code instanceof Code) {
					//code active?
					if ($code->active) {
						//code used?
						if (is_null($code->used_at)) {
							//code just for this lanparty?
							if (!empty($code->lanparty_id)) {
								if ($code->lanparty_id == $lanparty->id) {
									//ready for use
									$code->user_id = $user->id;
									$code->lanparty_id = $lanparty->id;
									$code->seat_id = $seat->id;
									$code->used_at = $now;
									$code->save();
									
									//set seat to payed status 
									$seat->status = 3;
									$seat->payed_at = $now;
									$seat->save();
									
									//and add gnb coins
									$coin = new Coin();
									$coin->coins = config('lanparty')['coins'];
									$coin->description = 'Sitzplatz #' . $seat->seatnumber . ' der ' . $lanparty->title . ' wurde per Gutschein bezahlt.';
									$user->coins()->save($coin);
									
									$request->session()->flash('alert-success', 'Code akzeptiert! Der Sitzplatz wurde bezahlt.');
								}
								else {
									$request->session()->flash('alert-danger', 'Der Code kann für diese Lanparty nicht genutzt werden.');
								}
							}
							else {
								//ready for use
								$code->user_id = $user->id;
								$code->lanparty_id = $lanparty->id;
								$code->seat_id = $seat->id;
								$code->used_at = new Carbon();
								$code->save();
								
								//set seat to payed status 
								$seat->status = 3;
								$seat->payed_at = $now;
								$seat->save();
								
								//and add gnb coins
								$coin = new Coin();
								$coin->coins = config('lanparty')['coins'];
								$coin->description = 'Sitzplatz #' . $seat->seatnumber . ' der ' . $lanparty->title . ' wurde per Gutschein bezahlt.';
								$user->coins()->save($coin);
								
								$request->session()->flash('alert-success', 'Code akzeptiert! Der Sitzplatz wurde bezahlt.');
							}
						}
						else {
							$request->session()->flash('alert-danger', 'Dieser Code wurde bereits benutzt.');
						}
					}
					else {
						$request->session()->flash('alert-danger', 'Dieser Code ist nicht aktiv.');
					}
				}
				else {
					$request->session()->flash('alert-warning', 'Dieser Code ist uns nicht bekannt.');
				}
			}
			else {
				$request->session()->flash('alert-warning', 'Dieser Code ist uns nicht bekannt.');
			}
		}
		else {
			$request->session()->flash('alert-danger', 'Es trat ein Fehler auf.');
		}
		return redirect(route('lanparty.reservation'));
	}
	
	/**
	 * reserve a seat by coins
	 * 
	 * @param Request $request
	 */
	public function reservationCoins(Request $request) {
		if (!Auth::check()) {
			return redirect(route('home'));
		}
		
		$now = new Carbon();
		$user = Auth::user();
		if ($request->user == $user->id) {
			$seat = Seat::findOrFail($request->seat);
			$lanparty = Lanparty::findOrFail($request->lanparty);
			
			if (!is_null($seat) && !is_null($lanparty)) {
				if ($user->coins()->lists('coins')->sum() >= config('lanparty')['paybycoins']) {
					//user get enough coins to pay
					$coin = new Coin();
					$coin->coins = config('lanparty')['paybycoins'] * (-1);
					$coin->description = 'Sitzplatz #' . $seat->seatnumber . ' der ' . $lanparty->title . ' wurde mit ' . config('lanparty')['paybycoins'] . ' GnB-Coins bezahlt.';
					$user->coins()->save($coin);
					
					//set reservation
					$seat->status = 3;
					$seat->reserved_at = $now;
					$seat->payed_at = $now;
					$seat->save();
					
					$request->session()->flash('alert-success', 'Der Sitzplatz wurde mit deinen GnB-Coins reserviert und bezahlt.');
				}
				else {
					$request->session()->flash('alert-danger', 'Du hast nicht genug GnB-Coins.');
				}
			}
			else {
				$request->session()->flash('alert-danger', 'Es trat ein Fehler auf.');
			}
		}
		else {
			$request->session()->flash('alert-danger', 'Es trat ein Fehler auf.');
		}
		return redirect(route('lanparty.reservation'));
	}
	
	/**
	 * get seatingplan view
	 */
	public function plan() {

	    $reservedseats = null;
		$lanparty = Lanparty::getNextLan();
		$user = (Auth::check()) ? Auth::user() : null;

        if ($lanparty instanceof Lanparty) {
            $reservedseats = $lanparty->getReservedSeats();
        }

		return view('lanparty.seatingplan')
		->with('lanparty', $lanparty)
		->with('user', $user)
		->with('reservedseats', $reservedseats);
	}
	
	/**
	 * get member list view
	 */
	public function member() {

	    $reservedseats = null;
		$lanparty = Lanparty::getNextLan();
        if ($lanparty instanceof Lanparty) {
            $reservedseats = $lanparty->getReservedSeats();
            ksort($reservedseats);
        }

		return view('lanparty.member')
		->with('lanparty', $lanparty)
		->with('reservedseats', $reservedseats);
	}
	
	/**
	 * ADMIN AREA
	 */
	
    /**
     * admin lanparty list
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
	public function listing() {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
			return redirect(route('home'));
		}
		
		$lanparties = Lanparty::all();
		
		return view('admin.lanparty.list')
			->with('lanparties', $lanparties)
			->with('now', new Carbon());
	}
	
	/**
	 * admin dashboard
	 * 
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
    public function add() {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
            return redirect(route('home'));
        }
        return view('admin.lanparty.add');
    }
    
    /**
     * add a new lanparty
     * 
     * @param Request $request
     */
    public function postAdd(Request $request) {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}
    	
    	$messages = [
    		'title.required' => 'Bitte gebe einen Titel an.',
    		'title.max' => 'Der Titel darf nicht länger als 255 Zeichen sein.',
    		'start.required' => 'Bitte gebe ein Start-Datum an.',
    		'start.date_format' => 'Bitte gebe ein korrektes Datum ein.',
    		'end.required' => 'Bitte gebe ein End-Datum an.',
    		'end.date_format' => 'Bitte gebe ein korrektes Datum ein.',
			'end.after' => 'Das End-Datum muss größer oder gleich dem Start-Datum sein.',
    		'registrationstart.required' => 'Bitte gebe ein Anmelde-Start-Datum an.',
    		'registrationstart.date_format' => 'Bitte gebe ein korrektes Datum ein.',
    		'registrationstart.before' => 'Das Anmelde-Start-Datum muss vor dem Start-Datum der Lanparty liegen.',
    		'registrationend.required' => 'Bitte gebe ein Anmelde-End-Datum an.',
    		'registrationend.date_format' => 'Bitte gebe ein korrektes Datum ein.',
    		'registrationend.after' => 'Das Anmelde-End-Datum muss hinter dem Anmelde-Start-Datum liegen.',
    		'registrationend.before' => 'Das Anmelde-End-Datum muss vor dem Start-Datum der Lanparty liegen.',
    		'reasonforpayment.required' => 'Bitte gebe einen Verwendungszweck an.',
    		'reasonforpayment.max' => 'Der Verwendungszweck darf nicht länger als 10 Zeichen sein.',
    		'reasonforpayment.unique' => 'Dieser Verwendungszweck wurde schon benutzt.'
    	];
    	
    	$validator = Validator::make($request->all(), [
    		'title' => 'required|max:255',
    		'subtitle' => 'max:255',
    		'start' => 'required|date_format:d.m.Y H:i',
    		'end' => 'required|date_format:d.m.Y H:i|after:start',
    		'registrationstart' => 'required|date_format:d.m.Y H:i|before:start',
    		'registrationend' => 'required|date_format:d.m.Y H:i|after:registrationstart|before:start',
    		'reasonforpayment' => 'required|max:10|unique:lanparties'
    	], $messages);
    	
    	if ($validator->fails()) {
    		return redirect(route('admin.lanparty.add'))
    			->withErrors($validator)
    			->withInput();
    	}
    	else {
    		//add new lanparty
    		$lanparty = new Lanparty();
			$lanparty->title = $request->title;
			$lanparty->subtitle = $request->subtitle;
			$lanparty->description = $request->description;
    		$lanparty->start = Carbon::createFromFormat('d.m.Y H:i', $request->start)->format('Y-m-d H:i:s');
    		$lanparty->end = Carbon::createFromFormat('d.m.Y H:i', $request->end)->format('Y-m-d H:i:s');
    		$lanparty->registrationstart = Carbon::createFromFormat('d.m.Y H:i', $request->registrationstart)->format('Y-m-d H:i:s');
    		$lanparty->registrationend = Carbon::createFromFormat('d.m.Y H:i', $request->registrationend)->format('Y-m-d H:i:s');
    		$lanparty->markeddays = config('lanparty')['markeddays'];
    		$lanparty->releaseseataftermarkeddays = config('lanparty')['releaseseataftermarkeddays'];
    		$lanparty->costs = config('lanparty')['costs'];
    		$lanparty->coins = config('lanparty')['coins'];
    		$lanparty->accountholder = config('lanparty')['accountholder'];
    		$lanparty->accountnumber = config('lanparty')['accountnumber'];
    		$lanparty->iban = config('lanparty')['iban'];
    		$lanparty->bic = config('lanparty')['bic'];
    		$lanparty->reasonforpayment = $request->reasonforpayment;
    		$lanparty->reserveregularseats = config('lanparty')['reserveregularseats'];
    		$lanparty->save();
    		
    		//check if regular seats will be reserved
    		if ($lanparty->reserveregularseats) {
    			$regularseats = Regularseat::all();
    			foreach ($regularseats as $regularseat) {
    				$seat = new Seat();
    				$seat->user_id = $regularseat->user_id;
    				$seat->seatnumber = $regularseat->seatnumber;
    				$seat->status = $regularseat->status;
    				if ($seat->status == 1) {
    					$seat->marked_at = new Carbon();
    				}
    				elseif ($seat->status == 2) {
    					$seat->reserved_at = new Carbon();
    				}
    				elseif ($seat->status == 3) {
    					$seat->payed_at = new Carbon();
    				}
    				$lanparty->seats()->save($seat);
    			}
    		}
    		
    		$request->session()->flash('alert-success', 'Die Lanparty wurde angelegt.');
    		return redirect(route('admin.lanparty.listing'));
    	}
    }
    
    /**
     * edit a lanparty
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function edit($id = 0) {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}

    	$lanparty = Lanparty::findOrFail($id);

    	return view('admin.lanparty.edit')
    		->with('lanparty', $lanparty);
    }
    
    /**
     * edit a lanparty
     *
     * @param Request $request
     */
    public function postEdit(Request $request) {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}
    	
    	$messages = [
    		'title.required' => 'Bitte gebe einen Titel an.',
    		'title.max' => 'Der Titel darf nicht länger als 255 Zeichen sein.',
    		'start.required' => 'Bitte gebe ein Start-Datum an.',
   			'start.date_format' => 'Bitte gebe ein korrektes Datum ein.',
   			'end.required' => 'Bitte gebe ein End-Datum an.',
   			'end.date_format' => 'Bitte gebe ein korrektes Datum ein.',
   			'end.after' => 'Das End-Datum muss größer oder gleich dem Start-Datum sein.',
    		'registrationstart.required' => 'Bitte gebe ein Anmelde-Start-Datum an.',
    		'registrationstart.date_format' => 'Bitte gebe ein korrektes Datum ein.',
    		'registrationstart.before' => 'Das Anmelde-Start-Datum muss vor dem Start-Datum der Lanparty liegen.',
   			'registrationend.required' => 'Bitte gebe ein Anmelde-End-Datum an.',
    		'registrationend.date_format' => 'Bitte gebe ein korrektes Datum ein.',
    		'registrationend.after' => 'Das Anmelde-End-Datum muss hinter dem Anmelde-Start-Datum liegen.',
    		'registrationend.before' => 'Das Anmelde-End-Datum muss vor dem Start-Datum der Lanparty liegen.',
    		'reasonforpayment.required' => 'Bitte gebe einen Verwendungszweck an.',
    		'reasonforpayment.max' => 'Der Verwendungszweck darf nicht länger als 10 Zeichen sein.',
    		'reasonforpayment.unique' => 'Dieser Verwendungszweck wurde schon benutzt.'
    	];
    	 
    	$validator = Validator::make($request->all(), [
    		'title' => 'required|max:255',
    		'subtitle' => 'max:255',
    		'start' => 'required|date_format:d.m.Y',
    		'end' => 'required|date_format:d.m.Y|after:start',
    		'registrationstart' => 'required|date_format:d.m.Y|before:start',
    		'registrationend' => 'required|date_format:d.m.Y|after:registrationstart|before:start',
    		'reasonforpayment' => 'required|max:10|unique:lanparties,id,' . $request->id
    	], $messages);
    	 
    	if ($validator->fails()) {
    		return redirect(route('admin.lanparty.edit', [$request->id]))
    		->withErrors($validator)
    		->withInput();
    	}
    	else {
    		$lanparty = Lanparty::findOrFail($request->id);
    		$lanparty->title = $request->title;
    		$lanparty->subtitle = $request->subtitle;
    		$lanparty->description = $request->description;
    		$lanparty->start = Carbon::createFromFormat('d.m.Y', $request->start)->startOfDay()->addHours(12)->format('Y-m-d H:i:s');
    		$lanparty->end = Carbon::createFromFormat('d.m.Y', $request->end)->startOfDay()->addHours(14)->format('Y-m-d H:i:s');
    		$lanparty->registrationstart = Carbon::createFromFormat('d.m.Y', $request->registrationstart)->startOfDay()->format('Y-m-d H:i:s');
    		$lanparty->registrationend = Carbon::createFromFormat('d.m.Y', $request->registrationend)->startOfDay()->addHours(12)->format('Y-m-d H:i:s');
    		$lanparty->reasonforpayment = $request->reasonforpayment;
    		$lanparty->update();
    
    		$request->session()->flash('alert-success', 'Die Lanparty wurde aktualisiert.');
    		return redirect(route('admin.lanparty.listing'));
    	}
    }
    
    /**
     * delete a lanparty
     * 
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function postDelete(Request $request) {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}
    	$lanparty = Lanparty::findOrFail($request->id);
    	$lanparty->delete();
    	
    	$request->session()->flash('alert-success', 'Die Lanparty wurde gelöscht.');
    	return redirect(route('admin.lanparty.listing'));
    }
    
    /**
     * get view for regularseats
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function getRegularseats() {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}
    	
    	$regularseats = array();
    	$res = Regularseat::with('user')->get();
    	foreach ($res as $regularseat) {
    		$regularseats[$regularseat->seatnumber] = $regularseat;
    	}
    	
    	
    	return view('admin.lanparty.regularseats')
    		->with('regularseats', $regularseats);
    }
    
    /**
     * add and delete regular seats
     * 
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function postRegularseats(Request $request) {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}
    	
    	//delete a regular seat
    	if ($request->action == 'delete') {
    		DB::table('regularseats')->where('id', $request->id)->delete();
    		
    		$request->session()->flash('alert-success', 'Stammplatz wurde erfolgreich gelöscht.');
    		return redirect(route('admin.lanparty.regularseats'));
    	}
    	
    	if ($request->action == 'reserve' && $request->user_id > 0) {
    		$regularseat = new Regularseat();
    		$regularseat->user_id = $request->user_id;
    		$regularseat->seatnumber = $request->seatnumber;
    		$regularseat->status = $request->status;
    		$regularseat->save();
    		
    		$request->session()->flash('alert-success', 'Stammplatz wurde erfolgreich vergeben.');
    		return redirect(route('admin.lanparty.regularseats'));
    	}
    	else {
    		//try to find user by name
    		if (DB::table('users')->where('name', 'like', $request->name)->count() == 1) {
    			$user = DB::table('users')->where('name', 'like', $request->name)->first();
    			
    			$regularseat = new Regularseat();
    			$regularseat->user_id = $user->id;
    			$regularseat->seatnumber = $request->seatnumber;
    			$regularseat->status = $request->status;
    			$regularseat->save();
    			
    			$request->session()->flash('alert-success', 'Stammplatz wurde erfolgreich vergeben.');
    			return redirect(route('admin.lanparty.regularseats'));
    		}
    		else {
    			$request->session()->flash('alert-danger', 'Benutzer wurde nicht gefunden! Der Stammplatz konnte nicht vergeben werden.');
    			return redirect(route('admin.lanparty.regularseats'));
    		}
    	}
    }
    
    /**
     * get the seatingplan view
     * 
     * @param number $id
     */
    public function seatingplan($id = 0) {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}

    	$reservedseats = [];
        $freeseats = [];

    	//get the next lanparty
    	$lanparty = Lanparty::findOrFail($id);
        if ($lanparty instanceof Lanparty) {
            $reservedseats = $lanparty->getReservedSeats();

            $freeseats = array();
            for ($i=1; $i<=220; $i++) {
                if (!isset($reservedseats[$i])) {
                    $freeseats[$i] = $i;
                }
            }
        }

    	return view('admin.lanparty.seatingplan')
    		->with('lanparty', $lanparty)
    		->with('reservedseats', $reservedseats)
    		->with('freeseats', $freeseats);
    }
    
    /**
     * post seatingplan action
     * 
     * @param number $id
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function postSeatingplan($id = 0, Request $request) {
        if (!Auth::check() || !Auth::user()->hasRole('lanpartymanager')) {
    		return redirect(route('home'));
    	}
    	
    	$now = new Carbon();
    	$lanparty = Lanparty::findOrFail($id);
    	
    	if (!is_null($lanparty)) {
    		
	    	//disable a seat
	    	if ($request->action == 'disable') {
	    		$seat = new Seat();
	    		$seat->seatnumber = $request->seatnumber;
	    		$seat->status = -1;
	    		$lanparty->seats()->save($seat);
	    		
	    		$request->session()->flash('alert-success', 'Der Sitzplatz wurde deaktiviert.');
	    		return redirect(route('admin.lanparty.seatingplan', [$lanparty->id]));
	    	}
	    	
	    	//activate a seat
	    	if ($request->action == 'activate') {
	    		DB::table('seats')->where('id', $request->id)->delete();
	    		
	    		$request->session()->flash('alert-success', 'Der Sitzplatz ist wieder aktiv.');
	    		return redirect(route('admin.lanparty.seatingplan', [$lanparty->id]));
	    	}
	    	
	    	//reserve a seat for user
	    	if ($request->action == 'reserve' && $request->user_id > 0) {
	    		$seat = new Seat();
	    		$seat->user_id = $request->user_id;
	    		$seat->seatnumber = $request->seatnumber;
	    		$seat->status = $request->status;
	    		if ($request->status == 1) {
	    			$seat->marked_at = $now;
	    		}
	    		elseif ($request->status == 2) {
	    			$seat->reserved_at = $now;
	    		}
	    		elseif ($request->status == 3) {
	    			$seat->payed_at = $now;
	    		}
	    		$lanparty->seats()->save($seat);
	    	
	    		$request->session()->flash('alert-success', 'Der Sitzplatz wurde erfolgreich reserviert.');
	    		return redirect(route('admin.lanparty.seatingplan', [$lanparty->id]));
	    	}
	    	elseif ($request->action == 'reserve') {
	    		//try to find user by name
	    		if (DB::table('users')->where('name', 'like', $request->name)->count() == 1) {
	    			$user = DB::table('users')->where('name', 'like', $request->name)->first();
	    			 
	    			$seat = new Seat();
	    			$seat->user_id = $user->id;
	    			$seat->seatnumber = $request->seatnumber;
	    			$seat->status = $request->status;
	    			if ($request->status == 1) {
	    				$seat->marked_at = $now;
	    			}
	    			elseif ($request->status == 2) {
	    				$seat->reserved_at = $now;
	    			}
	    			elseif ($request->status == 3) {
	    				$seat->payed_at = $now;
	    			}
	    			$lanparty->seats()->save($seat);
	    			
	    			$request->session()->flash('alert-success', 'Der Sitzplatz wurde erfolgreich vergeben.');
	    			return redirect(route('admin.lanparty.seatingplan', [$lanparty->id]));
	    		}
	    		else {
	    			$request->session()->flash('alert-danger', 'Benutzer wurde nicht gefunden! Der Sitzplatz konnte nicht reserviert werden.');
	    			return redirect(route('admin.lanparty.seatingplan', [$lanparty->id]));
	    		}
	    	}
	    	
	    	//change a seatnumber
	    	if ($request->action == 'change') {
	    		$seat = $lanparty->seats()->find($request->id);
	    		$seat->seatnumber = $request->seatnumber;
	    		$seat->update();
	    		
	    		$request->session()->flash('alert-success', 'Der Sitzplatz wurde erfolgreich aktualisiert.');
	    		return redirect(route('admin.lanparty.seatingplan', [$lanparty->id]));
	    	}
    	}
    }
    
    /**
     * get the memberlist view of a lanparty
     * 
     * @param number $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function memberlist($id = 0) {
    	$lanparty = Lanparty::findOrFail($id);
    	$now = new Carbon();
    	
    	return view('admin.lanparty.memberlist')
    		->with('lanparty', $lanparty)
    		->with('now', $now);
    }
    
    /**
     * validate and action for post memberlist
     * 
     * @param number $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function postMemberlist($id = 0, Request $request) {
    	$lanparty = Lanparty::findOrFail($id);
    	$now = new Carbon();
    	
    	if ($lanparty instanceof \App\Lanparty) {
    		
    		//free a seat
    		if ($request->action == 'free') {
    			DB::table('seats')->where('id', $request->seat)->delete();
    		
    			$request->session()->flash('alert-success', 'Der Sitzplatz wurde wieder freigegeben.');
    		}
    		
    		//reserve a seat
    		if ($request->action == 'reserve') {
    			$seat = Seat::findOrFail($request->seat);
    			if ($seat instanceof \App\Seat) {
    				$seat->reserved_at = $now;
    				$seat->status = 2;
    				$seat->save();
    				
    				$request->session()->flash('alert-success', 'Der Sitzplatz wurde reserviert.');
    			}
    		}
    		
    		//pay a seat
    		if ($request->action == 'pay') {
    			$seat = Seat::findOrFail($request->seat);
    			if ($seat instanceof \App\Seat) {
    				$seat->payed_at = $now;
    				$seat->status = 3;
    				$seat->save();
    				
    				//add gnb coins
    				$coin = new Coin();
    				$coin->coins = config('lanparty')['coins'];
    				$coin->description = $lanparty->title . ' wurde bezahlt.';
    				
    				$user = User::findOrFail($request->user);
    				if ($user instanceof \App\User) {
    					$user->coins()->save($coin);
    				}
    		
    				$request->session()->flash('alert-success', 'Der Sitzplatz wurde bezahlt.');
    			}
    		}
    	}
    	
    	return redirect(route('admin.lanparty.memberlist', [$id]));
    }

}
