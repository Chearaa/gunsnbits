<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bankaccountcheck extends Model
{

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'bankaccountcheck';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'last_check'
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
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'last_check'];

    /**
     * The models loaded with.
     *
     * @var array
     */
    protected $with = [];
}
