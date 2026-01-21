<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'user_subscription_id',
        'amount',
        'stripe_payment_intent_id',
        'status',

    ];
}
