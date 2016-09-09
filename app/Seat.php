<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Seat extends Model
{
	use SoftDeletes;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seatnumber',
    	'status',
    	'marked_at',
    	'reserved_at',
    	'payed_at'
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
    protected $dates = ['marked_at', 'reserved_at', 'payed_at'];
    
    protected $with = ['User'];
    
    /**
     * get the lanparty
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lanparty() {
    	return $this->belongsTo(Lanparty::class);
    }
    
    /**
     * get the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
    	return $this->belongsTo(User::class);
    }
    
    /**
     * get the status color
     * 
     * @return string
     */
    public function color() {
    	$color = '';
    	if ($this->status == 0) {
    		$color = 'success';
    	}
    	if ($this->status == 1) {
    		$color = 'warning';
    	}
    	elseif ($this->status == 2) {
    		$color = 'danger';
    	}
    	elseif ($this->status == 3) {
    		$color = 'danger';
    	}
    	elseif ($this->status == -1) {
    		$color = 'info';
    	}
    	
    	return $color;
    }
    
    /**
     * get the code of the seat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function code() {
    	return $this->hasOne('App\Code');
    }
}
