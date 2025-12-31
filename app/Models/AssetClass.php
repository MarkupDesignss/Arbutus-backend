<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetClass extends Model
{
    protected $table = 'asset_classes';

    protected $fillable = [
        'name',
        'status',
    ];
}
