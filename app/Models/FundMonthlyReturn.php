<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundMonthlyReturn extends Model
{
    protected $table = 'fund_monthly_returns';

    protected $fillable = [
        'fund_id',
        'fundatakey',
        'month_end',
        'monthly_return',
        'distribution_yield'
    ];

    // Relationships
    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }
}
