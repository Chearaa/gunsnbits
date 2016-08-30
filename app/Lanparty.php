<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Lanparty extends Model
{
	use SoftDeletes;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    	'subtitle',
    	'description',
    	'start',
    	'end',
    	'registrationstart',
    	'registrationend',
    	'markeddays',
    	'releaseseataftermarkeddays',
    	'costs',
    	'coins',
    	'accountholder',
    	'accountnumnber',
    	'banknumber',
    	'iban',
    	'bic',
    	'reasonforpayment',
    	'reserveregularseats'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'start', 'end', 'registrationstart', 'registrationend'];
    
    /**
     * get the seats of the lanparty
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seats() {
    	return $this->hasMany('App\Seat');
    }
    
    /**
     * get next lan
     */
    public static function getNextLan() {
    	$now = new Carbon();
    	$lanparty = Lanparty::where('start', '>=', $now)
    		->orWhere('start', '<=', $now)
    		->where('end', '>=', $now)
    		->orderBy('start', 'asc')
    		->first();
    	if ($lanparty instanceof \App\Lanparty) {
    		return $lanparty;
    	}
    	return null;
    }
    
    /**
     * get all reserved seats
     * 
     * @return array
     */
    public function getReservedSeats() {
    	$reservedseats = array();
    	
    	$seats = $this->seats()->get();
    	foreach ($seats as $seat) {
    		$reservedseats[$seat->seatnumber] = $seat;
    	}
    	
    	return $reservedseats;
    }
    
    /**
     * get reservation list for startpage progress bar
     * 
     * @return array
     */
    public function getReservations() {
    	$reservations = array(
    		'deactivated' => array(),
    		'marked' => array(),
    		'reserved' => array()
    	);
    	 
    	$seats = $this->getReservedSeats();
    	foreach ($seats as $seat) {
    		if ($seat->status == -1) {
    			$reservations['deactivated'][$seat->seatnumber] = $seat;
    		}
    		if ($seat->status == 1) {
    			$reservations['marked'][$seat->seatnumber] = $seat;
    		}
    		if ($seat->status > 1) {
    			$reservations['reserved'][$seat->seatnumber] = $seat;
    		}
    	}
    	
    	return $reservations;
    }
    
    /**
     * get the codes of the lanparty
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codes() {
    	return $this->hasMany('App\Code');
    }
    
    public static function getAllInFuture() {
    	$now = new Carbon();
    	
    	$lanparties = Lanparty::where('start', '>=', $now)->get();
    	return $lanparties;
    }
}
