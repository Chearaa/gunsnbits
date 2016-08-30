<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regularseat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seatnumber'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];
    
    /**
     * get user of the regular seat
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
    	return $this->belongsTo('App\User');
    }
    
    
}
