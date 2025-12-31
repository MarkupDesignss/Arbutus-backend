<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategie extends Model
{
    protected $table = 'strategies';

    protected $fillable = [
        'name',
        'status',
    ];
}
