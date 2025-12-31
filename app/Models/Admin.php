<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'role',
        'address',
        'image',
        'status',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

