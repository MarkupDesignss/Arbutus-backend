<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurValue extends Model
{
    protected $table = 'our_values';

    protected $fillable = [
        'title',
        'image',
        'short_description',
        'long_description',
        'status',
    ];
}
