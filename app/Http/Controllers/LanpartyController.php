<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Redirect;
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
        $next_lan_free = false;

        //get next lanparty
		$lanparty = Lanparty::getNextLan();
		$user = (Auth::check()) ? Auth::user() : null;
		
		if ($lanparty instanceof Lanparty) {
			$reservedseats = $lanparty->getReservedSeats();
            $usercanreserveseats = (!is_null($user) && $user->seats()->where('lanparty_id', $lanparty->id)->where('status', '>', 0)->get()->count() < $user->maxseats) ? ($user->maxseats - $user->seats()->where('lanparty_id', $lanparty->id)->where('status', '>', 0)->get()->count()) : 0;

            //check if next lan is free for user
            if (!is_null($user) && $user->coins()->sum('coins')%1000 < config('lanparty')['coins'] && $user->coins()->sum('coins') >= 1000) {
                $next_lan_free = true;
            }
		}

		return view('lanparty.reservation')
			->with('lanparty', $lanparty)
			->with('user', $user)
			->with('usercanreserveseats', $usercanreserveseats)
			->with('reservedseats', $reservedseats)
            ->with('next_lan_free', $next_lan_free);
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

                        //check if user have a free lan
                        $userpaymentisfree = false;

                        if (Auth::user()->coins()->sum('coins')%1000 < config('lanparty')['coins'] && Auth::user()->coins()->sum('coins') >= 1000) {
                            $userpaymentisfree = true;
                        }

                        if ($userpaymentisfree) {
                            $seat->status = 3;
                            $seat->payed_at = $now;

                            //add coins
                            $coins = new Coin([
                                'coins' => config('lanparty')['coins'],
                                'description' => 'Sitzplatz #' . $request->seatnumber . ' der ' . $lanparty->name . ' wurde automatisch reserviert und bezahlt, da eine 1000ender-Grenze GnB-Coins erreicht wurde.'
                            ]);
                            Auth::user()->coins()->save($coins);
                        }
                        else {
                            $seat->status = 1;
                            $seat->marked_at = $now;
                        }
						$lanparty->seats()->save($seat);

                        if ($userpaymentisfree) {
                            flash('Die Reservierung wurde erfolgreich durchgeführt und direkt bezahlt, da du durch deine gesammelten GnB-Coins einen Sitzplatz auf der LAN kostenlos hast.', 'success');
                        }
                        else {
                            flash('Die Reservierung wurde erfolgreich durchgeführt.', 'success');
                        }
                        return redirect(route('lanparty.reservation'));
					}
					else {
						flash('Die Reservierung konnte nicht gespeichert werden.', 'danger');
						return redirect(route('lanparty.reservation'));
					}
				}
				else {
					flash('Zur Zeit kann leider keine Reservierung durchgeführt werden.', 'danger');
					return redirect(route('lanparty.reservation'));
				}
			}
			else {
				flash('Die Lanparty wurde nicht gefunden.', 'danger');
				return redirect(route('lanparty.reservation'));
			}
		}
		else {
			flash('Fehler bei der Reservierung.', 'danger');
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
		
		flash('Die Reservierung wurde storniert.', 'success');
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
									
									flash('Code akzeptiert! Der Sitzplatz wurde bezahlt.', 'success');
								}
								else {
									flash('Der Code kann für diese Lanparty nicht genutzt werden.', 'danger');
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
								
								flash('Code akzeptiert! Der Sitzplatz wurde bezahlt.', 'success');
							}
						}
						else {
							flash('Dieser Code wurde bereits benutzt.', 'danger');
						}
					}
					else {
						flash('Dieser Code ist nicht aktiv.', 'danger');
					}
				}
				else {
					flash('Dieser Code ist uns nicht bekannt.', 'warning');
				}
			}
			else {
				flash('Dieser Code ist uns nicht bekannt.', 'warning');
			}
		}
		else {
			flash('Es trat ein Fehler auf.', 'danger');
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
					
					flash('Der Sitzplatz wurde mit deinen GnB-Coins reserviert und bezahlt.', 'success');
				}
				else {
					flash('Du hast nicht genug GnB-Coins.', 'danger');
				}
			}
			else {
				flash('Es trat ein Fehler auf.', 'danger');
			}
		}
		else {
			flash('Es trat ein Fehler auf.', 'danger');
		}
		return redirect(route('lanparty.reservation'));
	}
	
	/**
	 * get seatingplan view
	 */
	public function plan() {

		return view('lanparty.seatingplan');
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

        $rules = [
            'title' => 'required|max:255',
            'subtitle' => 'max:255',
            'start' => 'required|date_format:d.m.Y H:i',
            'end' => 'required|date_format:d.m.Y H:i|after:start',
            'registrationstart' => 'required|date_format:d.m.Y H:i|before:start',
            'registrationend' => 'required|date_format:d.m.Y H:i|after:registrationstart|before:start',
            'reasonforpayment' => 'required|max:10|unique:lanparties,deleted_at,null'
        ];
    	
    	$validator = Validator::make($request->all(), $rules, $messages);
    	
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
    		
    		flash('Die Lanparty wurde angelegt.', 'success');
    		return redirect(route('admin.lanparty.list'));
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
     * @param int $id
     * @return Redirect
     */
    public function postEdit(Request $request, $id = 0) {
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
    		'reasonforpayment' => 'required|max:10|unique:lanparties,id,' . $request->id
    	], $messages);
    	 
    	if ($validator->fails()) {
    		return Redirect::back()
                ->withErrors($validator)
                ->withInput();
    	}
    	else {
    		$lanparty = Lanparty::findOrFail($id);
    		$lanparty->title = $request->title;
    		$lanparty->subtitle = $request->subtitle;
    		$lanparty->description = $request->description;
    		$lanparty->start = Carbon::createFromFormat('d.m.Y H:i', $request->start)->startOfDay()->format('Y-m-d H:i:s');
    		$lanparty->end = Carbon::createFromFormat('d.m.Y H:i', $request->end)->startOfDay()->format('Y-m-d H:i:s');
    		$lanparty->registrationstart = Carbon::createFromFormat('d.m.Y H:i', $request->registrationstart)->format('Y-m-d H:i:s');
    		$lanparty->registrationend = Carbon::createFromFormat('d.m.Y H:i', $request->registrationend)->format('Y-m-d H:i:s');
    		$lanparty->reasonforpayment = $request->reasonforpayment;
    		$lanparty->update();
    
    		flash('Die Lanparty wurde aktualisiert.', 'success');
    		return redirect(route('admin.lanparty.list'));
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
    	
    	flash('Die Lanparty wurde gelöscht.', 'success');
    	return redirect(route('admin.lanparty.list'));
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
    		
    		flash('Stammplatz wurde erfolgreich gelöscht.', 'success');
    		return redirect(route('admin.lanparty.regularseats'));
    	}
    	
    	if ($request->action == 'reserve' && $request->user_id > 0) {
    		$regularseat = new Regularseat();
    		$regularseat->user_id = $request->user_id;
    		$regularseat->seatnumber = $request->seatnumber;
    		$regularseat->status = $request->status;
    		$regularseat->save();
    		
    		flash('Stammplatz wurde erfolgreich vergeben.', 'success');
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
    			
    			flash('Stammplatz wurde erfolgreich vergeben.', 'success');
    			return redirect(route('admin.lanparty.regularseats'));
    		}
    		else {
    			flash('Benutzer wurde nicht gefunden! Der Stammplatz konnte nicht vergeben werden.', 'danger');
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
                $seat->user_id = Auth::user()->id;
	    		$lanparty->seats()->save($seat);
	    		
	    		flash('Der Sitzplatz wurde deaktiviert.', 'success');
	    		return redirect(route('admin.lanparty.seatingplan', [$lanparty->id]));
	    	}
	    	
	    	//activate a seat
	    	if ($request->action == 'activate') {
	    		DB::table('seats')->where('id', $request->id)->delete();
	    		
	    		flash('Der Sitzplatz ist wieder aktiv.', 'success');
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
	    	
	    		flash('Der Sitzplatz wurde erfolgreich reserviert.', 'success');
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
	    			
	    			flash('Der Sitzplatz wurde erfolgreich vergeben.', 'success');
	    			return redirect(route('admin.lanparty.seatingplan', [$lanparty->id]));
	    		}
	    		else {
	    			flash('Benutzer wurde nicht gefunden! Der Sitzplatz konnte nicht reserviert werden.', 'danger');
	    			return redirect(route('admin.lanparty.seatingplan', [$lanparty->id]));
	    		}
	    	}
	    	
	    	//change a seatnumber
	    	if ($request->action == 'change') {
	    		$seat = $lanparty->seats()->find($request->id);
	    		$seat->seatnumber = $request->seatnumber;
	    		$seat->update();
	    		
	    		flash('Der Sitzplatz wurde erfolgreich aktualisiert.', 'success');
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
    		
    			flash('Der Sitzplatz wurde wieder freigegeben.', 'success');
    		}
    		
    		//reserve a seat
    		if ($request->action == 'reserve') {
    			$seat = Seat::findOrFail($request->seat);
    			if ($seat instanceof \App\Seat) {
    				$seat->reserved_at = $now;
    				$seat->status = 2;
    				$seat->save();
    				
    				flash('Der Sitzplatz wurde reserviert.', 'success');
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
    		
    				flash('Der Sitzplatz wurde bezahlt.', 'success');
    			}
    		}
    	}
    	
    	return redirect(route('admin.lanparty.memberlist', [$id]));
    }

    public function usersettings() {
        $users = User::all();
        return view('admin.lanparty.usersettings', compact(
            'users'
        ));
    }

    public function usersettingsEdit($id) {
        $user = User::findOrFail($id);
        return view('admin.lanparty.useredit', compact(
            'user'
        ));
    }

    public function usersettingsUpdate(Request $request, $id) {
        $user = User::findOrFail($id);

        $messages = [
            'maxseats.required' => 'Du musst eine maximale Anzahl Sitzplätze angeben.',
            'maxseats.min' => 'Ein Benutzer muss mindestens 1 Sitzplatz reservieren können.',
            'maxseats.max' => 'Es können maximal 20 Sitzplätze durch eine Person reserviert werden.',
            'maxseats.integer' => 'Bitte gebe eine Zahl zwischen 1 und 20 ein.'
        ];

        $rules = [
            'maxseats' => 'required|min:1|max:20|integer'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('admin.lanparty.user.settings.edit', [$user->id]))
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $user->maxseats = $request->maxseats;
            $user->save();
        }

        flash('Die maximalen Sitzplätze wurden aktualisiert.', 'success');
        return redirect(route('admin.lanparty.user.settings.edit', [$user->id]));
    }

}
