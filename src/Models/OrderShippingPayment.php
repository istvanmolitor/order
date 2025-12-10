<?php

namespace Molitor\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderShippingPayment extends Model
{
    protected $table = 'order_shipping_payments';

    protected $fillable = [
        'order_shipping_id',
        'order_payment_id',
    ];

    public $timestamps = false;

    public function orderShipping(): BelongsTo
    {
        return $this->belongsTo(OrderShipping::class, 'order_shipping_id');
    }

    public function orderPayment(): BelongsTo
    {
        return $this->belongsTo(OrderPayment::class, 'order_payment_id');
    }
}
