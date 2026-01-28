<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsors extends Model
{
    protected $table = 'sponsors';

    protected $fillable = [
        'image',
        'status',
    ];
}
