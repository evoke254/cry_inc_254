<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Models\Admin\InvestmentPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserHasInvestPlan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'id'                    => "integer",
        'user_id'               => "integer",
        'invest_plan_id'        => "integer",
        'invest_amount'         => "decimal:8",
        'status'                => "string",
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function investPlan() {
        return $this->belongsTo(InvestmentPlan::class,'invest_plan_id');
    }

    public function scopeAuth($query) {
        return $query->where('user_id',auth()->user()->id);
    }

    public function scopeThisYear($query) {
        return $query->whereBetween('created_at',[now()->startOfYear(),now()->endOfYear()]);
    }

    public function scopeYearChartData($query) {
        return $query->select([
            DB::raw('sum(invest_amount) as total, YEAR(created_at) as year, MONTH(created_at) as month'),
        ])->groupBy('year','month')->pluck('total','month');
    }
}
