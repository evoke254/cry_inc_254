<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Http\Helpers\Response;
use App\Models\UserHasInvestPlan;
use App\Models\InvestmentProfitLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\Admin\BasicSettingsProvider;
use Pusher\PushNotifications\PushNotifications;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction = Transaction::query();

        $trx_add_money = Transaction::addMoney()->get();
        $trx_money_out = Transaction::moneyOut()->get();
        $support_ticket = SupportTicket::select(['id','status'])->get();
        $users = User::select(['id','status'])->get();
        $users_invest = UserHasInvestPlan::select(['id','invest_amount','created_at'])->get();
        $users_profit_log = InvestmentProfitLog::select(['id','invest_id','profit_amount'])->get();
        
        $this_months_days = CarbonPeriod::between(now()->subDays(30),today()->endOfDay());
        
        $this_year_months = CarbonPeriod::between(now()->startOfYear(),now()->endOfYear())->months()->toArray();

        $pending_add_money_chart_data   = Transaction::addMoney()->thisMonth()->pending()->chartData()->toArray();
        $success_add_money_chart_data   = Transaction::addMoney()->thisMonth()->complete()->chartData()->toArray();
        $rejected_add_money_chart_data  = Transaction::addMoney()->thisMonth()->reject()->chartData()->toArray();
        $all_add_money_chart_data       = Transaction::addMoney()->thisMonth()->chartData()->toArray();

        // Revenue START
        $pending_revenue_this_year      = Transaction::pending()->thisYear()->yearChartData()->toArray();
        $success_revenue_this_year      = Transaction::complete()->thisYear()->yearChartData()->toArray();
        $reject_revenue_this_year       = Transaction::reject()->thisYear()->yearChartData()->toArray();
        $all_revenue_this_year          = Transaction::thisYear()->yearChartData()->toArray();

        $month_wise_pending_revenue = array_values($this->revenueFormatter($this_year_months,$pending_revenue_this_year));
        $month_wise_complete_revenue = array_values($this->revenueFormatter($this_year_months,$success_revenue_this_year));
        $month_wise_reject_revenue = array_values($this->revenueFormatter($this_year_months,$reject_revenue_this_year));
        $month_wise_all_revenue = array_values($this->revenueFormatter($this_year_months,$all_revenue_this_year));
        // Revenue END

        // Investment Analytics START
        $investments = UserHasInvestPlan::thisYear()->yearChartData()->toArray();
        $monthly_investments = array_values($this->investmentFormatter($this_year_months,$investments));
        // Investment Analytics END

        // user Analytics START
        $active_users               = User::active()->count();
        $banned_users               = User::banned()->count();
        $email_unverified_users     = User::emailUnverified()->count();
        // user Analytics END


        // Growth START
        // dd(today()->toDateString());
        $today_profit_amount = Transaction::complete()->whereDate('created_at',today()->toDateString())
                                            ->pluck('total_charge')
                                            ->sum();

        $this_profit_week_amount    = Transaction::complete()->whereBetween('created_at',[now()->startOfWeek(),now()->endOfWeek()])->pluck('total_charge')->sum();
        $this_profit_month_amount   = Transaction::complete()->whereBetween('created_at',[now()->startOfMonth(),now()->endOfMonth()])->pluck('total_charge')->sum();
        $this_profit_year_amount    = Transaction::complete()->whereBetween('created_at',[now()->startOfYear(),now()->endOfYear()])->pluck('total_charge')->sum();
        // Growth END

        // latest 5 transaction
        $latest_transactions = Transaction::addMoney()->latest()->take(5)->get();

        // dd($latest_transactions);


        $page_title = "Dashboard";
        return view('admin.sections.dashboard.index',compact(
            'page_title',
            'trx_add_money',
            'trx_money_out',
            'support_ticket',
            'users',
            'users_invest',
            'users_profit_log',
            'this_months_days',
            'pending_add_money_chart_data',
            'success_add_money_chart_data',
            'rejected_add_money_chart_data',
            'all_add_money_chart_data',
            'this_year_months',
            'month_wise_pending_revenue',
            'month_wise_complete_revenue',
            'month_wise_reject_revenue',
            'month_wise_all_revenue',
            'monthly_investments',
            'active_users',
            'banned_users',
            'email_unverified_users',
            'today_profit_amount',
            'this_profit_week_amount',
            'this_profit_month_amount',
            'this_profit_year_amount',
            'latest_transactions',
        ));
    }


    /**
     * Logout Admin From Dashboard
     * @return view
     */
    public function logout(Request $request) {

        $push_notification_setting = BasicSettingsProvider::get()->push_notification_config;

        if($push_notification_setting) {
            $method = $push_notification_setting->method ?? false;

            if($method == "pusher") {
                $instant_id     = $push_notification_setting->instance_id ?? false;
                $primary_key    = $push_notification_setting->primary_key ?? false;

                if($instant_id && $primary_key) {
                    $pusher_instance = new PushNotifications([
                        "instanceId"    => $instant_id,
                        "secretKey"     => $primary_key,
                    ]);

                    $pusher_instance->deleteUser("".Auth::user()->id."");
                }
            }

        }

        $admin = auth()->user();
        try{
            $admin->update([
                'last_logged_out'   => now(),
                'login_status'      => false,
            ]);
        }catch(Exception $e) {
            // Handle Error
        }

        Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    /**
     * Function for clear admin notification
     */
    public function notificationsClear() {
        $admin = auth()->user();

        if(!$admin) {
            return false;
        }

        try{
            $admin->update([
                'notification_clear_at'     => now(),
            ]);
        }catch(Exception $e) {
            $error = ['error' => ['Something went wrong! Please try again.']];
            return Response::error($error,null,404);
        }

        $success = ['success' => ['Notifications clear successfully!']];
        return Response::success($success,null,200);
    }

    public function revenueFormatter($months, $revenues) {
        $month_wise_pending_revenue = [];
        foreach($months as $date) {
            foreach($revenues as $month => $revenue) {
                if($date->startOfMonth()->month == $month) {
                    $month_wise_pending_revenue[$date->startOfMonth()->month] = get_amount($revenue,null);
                    break;
                }else {
                    $month_wise_pending_revenue[$date->startOfMonth()->month] = 0;
                    break;
                }
            }
        }

        return $month_wise_pending_revenue;
    }

    public function investmentFormatter($month, $investments) {
        return $this->revenueFormatter($month, $investments);
    }
}
