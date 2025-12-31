<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    protected $table = 'firms';

    protected $fillable = [
        'name',
        'firm_aum',
        'status',
    ];
}
