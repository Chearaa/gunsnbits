<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coins',
    	'description'
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
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The user belongs to the coin 
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
}
