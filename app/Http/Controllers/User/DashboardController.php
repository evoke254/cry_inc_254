<?php
namespace App\Http\Controllers\User;

use App\Constants\GlobalConst;
use App\Constants\PaymentGatewayConst;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\UserHasInvestPlan;
use App\Models\UserWallet;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $page_title = "Dashboard";
        $wallets = UserWallet::auth()->get();
        $transaction_logs = Transaction::where(function($q) {
            $q->where('user_type',GlobalConst::USER)->orWhere('receiver_type',GlobalConst::USER);
        })->where(function($q) {
            $q->where('user_id',auth()->user()->id)->orWhere('receiver_id',auth()->user()->id);
        })->latest()->take(5)->get();

        $total_invest = UserHasInvestPlan::auth()->sum('invest_amount');
        $total_profit = $wallets->sum('profit_balance');

        $times = CarbonPeriod::between(now()->subDays(30),today());

        // Chart Data
        $add_money_chart = Transaction::where('type',PaymentGatewayConst::TYPEADDMONEY)
                                        ->where('user_type',GlobalConst::USER)
                                        ->where('user_id',auth()->user()->id)
                                        ->select([
                                            DB::raw('DATE(created_at) as date'),
                                            DB::raw("(sum(receive_amount)) as total_amount"),
                                        ])
                                        ->groupBy('date')
                                        ->pluck("total_amount")
                                        ->values()
                                        ->toArray();

        $money_out_chart = Transaction::where('type',PaymentGatewayConst::TYPEWITHDRAW)
                                        ->where('user_type',GlobalConst::USER)
                                        ->where('user_id',auth()->user()->id)
                                        ->select([
                                            DB::raw('DATE(created_at) as date'),
                                            DB::raw("(sum(request_amount)) as total_amount"),
                                        ])
                                        ->groupBy('date')
                                        ->pluck("total_amount")
                                        ->values()
                                        ->toArray();

        return view('user.dashboard',compact("page_title","wallets","transaction_logs","total_invest","total_profit",'times','add_money_chart','money_out_chart'));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login');
    }
}
