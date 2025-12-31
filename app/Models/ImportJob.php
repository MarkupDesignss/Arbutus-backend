<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportJob extends Model
{
    protected $table = 'import_jobs';

    protected $fillable = [
        'admin_id',
        'original_filename',
        'stored_filename',
        'status',
        'as_of_month',
        'total_rows',
        'valid_rows',
        'invalid_rows',
        'summary',
    ];

    // ✅ Define relationship with Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
