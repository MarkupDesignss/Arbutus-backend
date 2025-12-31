<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskRating extends Model 
{
    protected $table = 'risk_ratings';

    protected $fillable = [
        'name',
        'status',
    ];
}
