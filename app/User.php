<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = [
        'coins'
    ];

    /**
     * Get the facebook user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function facebookuser() {
        return $this->hasOne(Facebookuser::class);
    }

    /**
     * Get paypal transactions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paypals() {
        return $this->hasMany(Paypal::class);
    }

    /**
     * get regular seats of the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regularseats() {
        return $this->hasMany(Regularseat::class);
    }

    /**
     * get seats of the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seats() {
        return $this->hasMany(Seat::class);
    }

    /**
     * get the coins of the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coins() {
        return $this->hasMany(Coin::class);
    }

    /**
     * get the codes of the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codes() {
        return $this->hasMany(Code::class);
    }
}
