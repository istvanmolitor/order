<?php

namespace Molitor\Order\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusLog extends Model
{
    protected $fillable = [
        'order_id',
        'order_status_id',
    ];

    CONST UPDATED_AT = null;
}
