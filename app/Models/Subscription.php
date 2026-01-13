<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'name',
        'title',
        'monthly_price',
        'yearly_price',
        'is_popular',
        'features',
        'is_active',
    ];
}
