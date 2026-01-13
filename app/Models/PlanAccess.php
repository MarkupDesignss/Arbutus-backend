<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanAccess extends Model
{
    protected $table = 'plan_accesses';

    protected $fillable = [
        'subscription_id',
        'access_rule_id',
        'status',
    ];

    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }

    public function accessRule(){
        return $this->belongsTo(AccessRule::class);
    }

}
