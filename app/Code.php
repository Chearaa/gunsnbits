<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Code extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    	'lanparty_id',
    	'seat_id',
    	'code',
    	'active',
    	'used_at'
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
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'used_at'];

    protected $with = ['User', 'Lanparty', 'Seat'];
    
    /**
     * The user belongs to the code 
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    /**
     * The lanparty belongs to the code
     */
    public function lanparty() {
    	return $this->belongsTo('App\Lanparty');
    }
    
    /**
     * The seat belongs to the code
     */
    public function seat() {
    	return $this->belongsTo('App\Seat');
    }
    
    /**
     * get the code by hash
     * 
     * @param string $hash
     */
    public static function findByCode($hash = '') {
    	$hash = strtoupper($hash);
    	
    	$code = Code::where('code', '=', $hash)->first();
    	
    	if ($code instanceof Code) {
    		return $code;
    	}
    	
    	return null;
    }
}
