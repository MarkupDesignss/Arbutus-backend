<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'image',
        'status',
        'otp',
        'otp_expires_at',
    ];

    protected $hidden = [
        'otp',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
    ];
}
