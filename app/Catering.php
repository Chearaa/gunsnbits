<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catering extends Model
{
    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'caterings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'image',
        'description',
        'costs'
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
     * The models loaded with.
     *
     * @var array
     */
    protected $with = [];

}
