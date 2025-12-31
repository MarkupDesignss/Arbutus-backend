<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $table = 'funds';

    protected $fillable = [
        'fundatakey',
        'symbol_code',
        'fund_name',
        'firm_id',
        'asset_class_id',
        'type_id',
        'strategy_id',
        'category_id',
        'risk_rating_id',
        'one_month',
        'ytd',
        'one_year',
        'three_year',
        'since_inception',
        'three_year_std_dev',
        'distribution_yield',
        'inception_date',
        'fund_aum',
        'fund_library_link',
        'external_link',
        'status',
    ];

    // Relationships
    public function firm() {
        return $this->belongsTo(Firm::class);
    }

    public function assetClass() {
        return $this->belongsTo(AssetClass::class, 'asset_class_id');
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function strategy() {
        return $this->belongsTo(Strategie::class, 'strategy_id');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function riskRating() {
        return $this->belongsTo(RiskRating::class, 'risk_rating_id');
    }
}
