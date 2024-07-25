<?php

namespace App\Models;

use App\Constants\GlobalConst;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestmentProfitLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'id'                => "integer",
        'user_id'           => "integer",
        'invest_id'         => "integer",
        'profit_amount'     => "decimal:8",
    ];


    public function scopeAuth($query) {
        return $query->where('user_id',auth()->user()->id);
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function invest() {
        return $this->belongsTo(UserHasInvestPlan::class,'invest_id');
    }

    public function userWallet() {
        return $this->belongsTo(UserWallet::class,'wallet_id');
    }
    
}
