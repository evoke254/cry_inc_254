<?php

namespace App\Http\Controllers\User;

use App\Constants\GlobalConst;
use App\Http\Controllers\Controller;
use App\Http\Helpers\InvestmentProfitHelper;
use App\Models\Admin\InvestmentPlan;
use App\Models\UserHasInvestPlan;
use App\Providers\Admin\CurrencyProvider;
use App\Traits\User\RegisteredUsers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvestPlanController extends Controller
{
    use RegisteredUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Investment Plans";
        $investment_plans = InvestmentPlan::active()->get();
        return view('user.sections.invest-plan.index',compact('page_title','investment_plans'));
    }

    /**
     * Purchase a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function purchase(Request $request, InvestmentPlan $invest_plan)
    {
        $validator = Validator::make($request->all(),[
            'invest_amount'     => "required|numeric",
            'agree'             => "required|string|in:on",
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput()->with('modal','purchase-step');
        }

        $validated = $validator->validate();

        if($invest_plan->status != GlobalConst::ACTIVE) return back()->with(['error' => "Oops! This plan is no longer available"]);

        $user = auth()->user();
        $default_currency = CurrencyProvider::default();
        $user_wallet = $user->wallets->filter(function($item) use ($default_currency) {
            if($item->currency->code == $default_currency->code) return true;
            return false;
        })->first();
        if(!$user_wallet) return back()->with(['error' => ['Oops! Wallet not found!']]);

        if($validated['invest_amount'] < $invest_plan->min_invest_requirement || $validated['invest_amount'] > $invest_plan->max_invest) {
            return back()->with(['error' => ['Your can invest minimum ' . get_amount($invest_plan->min_invest_requirement,$user_wallet->currency->code) . " to maximum " . get_amount($invest_plan->max_invest,$user_wallet->currency->code)]]);
        }

        if($user_wallet->balance < $validated['invest_amount']) return back()->with(['error' => ['Your wallet balance is insufficient']]);

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

            $this->referUserLevelUpInspection($user);

            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            return back()->with(['error' => ['Oops! Something went wrong! Please try again']]);
        }

        return back()->with(['success' => ['New Investment Plan Purchase Successfully!']]);
    }

    
}
