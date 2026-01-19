<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundPerformanceSnapshot extends Model
{
    protected $table = 'fund_performance_snapshots';

    protected $fillable = [
        'fund_id',
        'as_of_month',
        'one_month',
        'ytd',
        'one_year',
        'three_year',
        'since_inception',
        'three_year_std_dev',
        'distribution_yield',
        'is_published',
    ];

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }
}
