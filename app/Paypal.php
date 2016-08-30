<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paypal extends Model
{
    /**
     * The table of this model.
     *
     * @var string
     */
    protected $table = 'paypals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'paypal_id',
        'intent',
        'state',
        'cart',
        'payer_status',
        'payer_email',
        'payer_first_name',
        'payer_last_name',
        'payer_id',
        'transaction_amount_total',
        'transaction_amount_currency',
        'transaction_description',
        'transaction_sale_id',
        'transaction_sale_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * Get the user of this transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paypalitems() {
        return $this->hasMany(PaypalItem::class);
    }
}
