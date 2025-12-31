<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'meta_tags',
        'content',
        'status',
    ];

    // Auto-generate slug from title if not set
    public static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (!$page->slug) {
                $page->slug = Str::slug($page->title, '_');
            }
        });

        static::updating(function ($page) {
            if (!$page->slug) {
                $page->slug = Str::slug($page->title, '_');
            }
        });
    }
}
