<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'long_description',
        'image',
        'author_name',
        'post_date',
        'type',
        'video_url',
        'status',
    ];
}
