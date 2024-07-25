<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Response;
use App\Models\User;
use App\Providers\Admin\CurrencyProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function referData()
    {

        $auth_user = Auth::user();

        $total_investment = $auth_user->investPlans->sum("invest_amount");

        $current_refer_level_status = false;
        $user_refer_level = $auth_user->referLevel;
        $share_text = "";
        if($user_refer_level) {
            $current_refer_level_status = true;
            $share_text = "Get " . get_amount($user_refer_level->commission, get_default_currency_code()) . " reward for every successfully referral.";
        }

        $next_refer_level = false;
        $user_next_refer_level = $auth_user->nextReferLevel();
        if($user_next_refer_level != false) $next_refer_level = true;
        
        $refer_user_ids = $auth_user->referUsers->pluck("new_user_id");
        $refer_users = User::whereIn('id',$refer_user_ids)->select('firstname','email','created_at','referral_id')->get();
        $refer_users->makeHIdden(['userImage','stringStatus','kycStringStatus','lastLogin']);

        return Response::success([__("Refer Data Fetch Successfully!")],[
            'basic'         => [
                'total_invested'        => (string) get_amount($total_investment),
                'total_refers'          => (string) $refer_users->count(),
                'currency_code'         => get_default_currency_code(),
                'refer_code'            => $auth_user->referral_id,
                'refer_link'            => setRoute('user.register',$auth_user->referral_id),
                'share_text'            => $share_text,
            ],

            'current_refer_level'       => [
                'status'            => $current_refer_level_status,
                'level'             => $user_refer_level
            ],

            'next_refer_level'          => [
                'status'            => $next_refer_level,
                'level'             => $user_next_refer_level
            ],

            'refer_users'           => $refer_users,
        ],200);
    }

    
}
