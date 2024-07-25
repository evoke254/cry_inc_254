<?php

namespace App\Models\Admin;

use App\Constants\GlobalConst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentPlan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'id'                    => 'integer',
        'duration'              => "string",
        'min_invest'            => 'decimal:8',
        'min_invest_offer'      => 'decimal:8',
        'max_invest'            => 'decimal:8',
        'profit_fixed'          => 'decimal:8',
        'profit_percent'        => 'decimal:8',
        'status'                => 'boolean',
    ];

    public function scopeActive($query) {
        return $query->where('status',GlobalConst::ACTIVE);
    }

    public function getMinInvestRequirementAttribute() {
        if($this->min_invest_offer > 0) {
            return $this->min_invest_offer;
        }
        return $this->min_invest;
    }
}
