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

}
