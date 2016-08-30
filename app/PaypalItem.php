<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paypalitem extends Model
{
    /**
     * The table of this model.
     *
     * @var string
     */
    protected $table = 'paypalitems';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'price',
        'currency',
        'quantity',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * Get the items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paypal() {
        return $this->belongsTo(Paypal::class);
    }
}
