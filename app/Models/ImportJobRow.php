<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportJobRow extends Model
{
    protected $table = 'import_job_rows';

    protected $fillable = [
        'import_job_id',
        'fundatakey',
        'month_end',
        'monthly_return',
        'distribution_yield',
        'is_valid',
        'errors'
    ];

    // ✅ Define relationship with ImportJob
    public function importJob()
    {
        return $this->belongsTo(ImportJob::class, 'import_job_id');
    }
}
