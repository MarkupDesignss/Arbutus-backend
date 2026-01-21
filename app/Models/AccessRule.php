<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessRule extends Model
{
    protected $table = 'access_rules';

    protected $fillable = [
        'module',
        'rule_type',
        'rule_key',
        'label',
        'status',
    ];
}
