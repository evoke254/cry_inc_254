<?php

namespace App\Http\Controllers\Api\V1\User;

use Exception;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Http\Helpers\Response;
use Illuminate\Support\Carbon;
use App\Models\UserHasInvestPlan;
use Illuminate\Support\Facades\DB;
use App\Models\InvestmentProfitLog;
use App\Http\Controllers\Controller;
use App\Models\Admin\InvestmentPlan;
use App\Providers\Admin\CurrencyProvider;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\InvestmentProfitHelper;

class InvestPlanController extends Controller
{

    public function investPlans() {
        $invest_plans = InvestmentPlan::active()->select('id','slug','name','duration','profit_return_type','min_invest','min_invest_offer','max_invest','profit_fixed','profit_percent','status','created_at')->get();

        return Response::success([__('Investment plan list fetch successfully!')],[
            'instructions'  => [
                'profit_return_type'    => [
                    GlobalConst::INVEST_PROFIT_ONE_TIME,
                    GlobalConst::INVEST_PROFIT_DAILY_BASIS,
                ],
                'status'                => "boolean",
            ],
            'plans'         => $invest_plans,
        ],200);
    }

    public function planPurchase(Request $request, InvestmentPlan $invest_plan) {

        $validator = Validator::make($request->all(),[
            'invest_amount'  => "required|numeric",
        ]);

        if($validator->fails()) {
            return Response::error($validator->errors()->all(),[],400);
        }
        $validated = $validator->validate();

        if($invest_plan->status != GlobalConst::ACTIVE) return Response::error([__('Oops! This plan is no longer available')],[],404);

        $user = auth()->user();
        $default_currency = CurrencyProvider::default();
        $user_wallet = $user->wallets->filter(function($item) use ($default_currency) {
            if($item->currency->code == $default_currency->code) return true;
            return false;
        })->first();
        if(!$user_wallet) return Response::error([__('Oops! Wallet not found!')],[],404);

        if($validated['invest_amount'] < $invest_plan->min_invest_requirement || $validated['invest_amount'] > $invest_plan->max_invest) {
            return Response::error(['Your can invest minimum ' . get_amount($invest_plan->min_invest_requirement,$user_wallet->currency->code) . " to maximum " . get_amount($invest_plan->max_invest,$user_wallet->currency->code)],[],400);
        }

        if($user_wallet->balance < $validated['invest_amount']) return Response::error([__('Your wallet balance is insufficient')],[],400);

        DB::beginTransaction();
        try{
            DB::table($user_wallet->getTable())->where('id',$user_wallet->id)->decrement('balance',$validated['invest_amount']);

            $inserted_id = DB::table('user_has_invest_plans')->insertGetId([
                'user_id'           => $user->id,
                'invest_plan_id'    => $invest_plan->id,
                'exp_at'            => Carbon::now()->addDays($invest_plan->duration),
                'invest_amount'     => $validated['invest_amount'],
                'created_at'        => now(),
            ]);

            $plan = UserHasInvestPlan::find($inserted_id);

            (new InvestmentProfitHelper($plan))->execute();

            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            return Response::error([__('Oops! Something went wrong! Please try again')],[],500);
        }

        return Response::success([__('New Investment Plan Purchase Successfully!')],[],200);

    }

    public function myInvestments() {
        $investments = UserHasInvestPlan::auth()->select('id','invest_plan_id','invest_amount','exp_at','status','created_at')->with(['investPlan' => function($q) {
            $q->select('id','name','slug','duration','profit_fixed','profit_percent');
        }])->get();

        return Response::success([__('Investment data fetch successfully!')],[
            'instructions'      => [
                'status'        => "1: Complete, 2: Running, 3: Cancel",
            ],
            'investments'       => $investments,
        ],200);
    }

    public function profitLog() {
        $profit_logs = InvestmentProfitLog::auth()->has('invest')->orderByDesc("id")->select('id','user_id','invest_id','profit_amount','created_at')->with(['invest' => function($q) {
            $q->select('id','invest_amount','invest_plan_id','status')->with(['investPlan' => function($q) {
                $q->select('id','name');
            }]);
        }])->get();

        return Response::success([__('Investment profit data fetch successfully!')],[
            'instructions'      => [
                'invest'        => [
                    'status'    => '1: Complete, 2: Running, 3: Cancel',
                ],
            ],
            'profit_logs'       => $profit_logs,
        ],200);
        
    }

}
