<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\Transaction;
use App\Models\UserMailLog;
use Illuminate\Support\Arr;
use App\Models\UserLoginLog;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Constants\GlobalConst;
use App\Http\Helpers\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\User\SendMail;
use Illuminate\Support\Facades\Auth;
use App\Constants\PaymentGatewayConst;
use App\Models\InvestmentProfitLog;
use App\Models\UserHasInvestPlan;
use App\Notifications\User\MessageNotification;
use App\Providers\Admin\BasicSettingsProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class UserCareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "All Users";
        $users = User::orderBy('id', 'desc')->paginate(12);
        return view('admin.sections.user-care.index', compact(
            'page_title',
            'users'
        ));
    }

    /**
     * Display Active Users
     * @return view
     */
    public function active()
    {
        $page_title = "Active Users";
        $users = User::active()->orderBy('id', 'desc')->paginate(12);
        return view('admin.sections.user-care.index', compact(
            'page_title',
            'users'
        ));
    }


    /**
     * Display Banned Users
     * @return view
     */
    public function banned()
    {
        $page_title = "Banned Users";
        $users = User::banned()->orderBy('id', 'desc')->paginate(12);
        return view('admin.sections.user-care.index', compact(
            'page_title',
            'users',
        ));
    }

    /**
     * Display Email Unverified Users
     * @return view
     */
    public function emailUnverified()
    {
        $page_title = "Email Unverified Users";
        $users = User::active()->orderBy('id', 'desc')->emailUnverified()->paginate(12);
        return view('admin.sections.user-care.index', compact(
            'page_title',
            'users'
        ));
    }

    /**
     * Display SMS Unverified Users
     * @return view
     */
    public function SmsUnverified()
    {
        $page_title = "SMS Unverified Users";
        return view('admin.sections.user-care.index', compact(
            'page_title',
        ));
    }

    /**
     * Display KYC Unverified Users
     * @return view
     */
    public function KycUnverified()
    {
        $page_title = "KYC Unverified Users";
        $users = User::kycUnverified()->orderBy('id', 'desc')->paginate(8);
        return view('admin.sections.user-care.index', compact(
            'page_title',
            'users'
        ));
    }

    /**
     * Display Send Email to All Users View
     * @return view
     */
    public function emailAllUsers()
    {
        $page_title = "Email To Users";
        return view('admin.sections.user-care.email-to-users', compact(
            'page_title',
        ));
    }

    /**
     * Display Specific User Information
     * @return view
     */
    public function userDetails($username)
    {
        $page_title = "User Details";
        $user = User::where('username', $username)->with(['referLevel','wallets'])->withCount(['referUsers'])->first();
        if(!$user) return back()->with(['error' => ['Oops! User not exists']]);
        $user_wallet = $user->defaultWallet();

        $user_pending_add_money = Transaction::where('user_type',GlobalConst::USER)->where('user_id',$user->id)->pending()->pluck("request_amount")->sum();
        $user_success_add_money = Transaction::where('user_type',GlobalConst::USER)->where('user_id',$user->id)->complete()->pluck("request_amount")->sum();

        $user_total_transactions = Transaction::where('user_type',GlobalConst::USER)->where('user_id',$user->id)->pluck('request_amount')->sum();
        $user_send_total = Transaction::where('user_type',GlobalConst::USER)->where('user_id',$user->id)->whereNot('receiver_id',auth()->user()->id)->pluck('request_amount')->sum();
        $user_receive_total = Transaction::where('user_type',GlobalConst::USER)->where('user_id',$user->id)->where('receiver_id',auth()->user()->id)->pluck('request_amount')->sum();

        $user_money_out = Transaction::where('user_type',GlobalConst::USER)->where('user_id',$user->id)->moneyOut()->pluck('request_amount')->sum();
        $user_pending_money_out = Transaction::where('user_type',GlobalConst::USER)->where('user_id',$user->id)->pending()->pluck('request_amount')->sum();
        $user_reject_money_out = Transaction::where('user_type',GlobalConst::USER)->where('user_id',$user->id)->reject()->pluck('request_amount')->sum();

        $active_support_ticket = SupportTicket::active()->count();
        $pending_support_ticket = SupportTicket::pending()->count();
        $solved_support_ticket = SupportTicket::solved()->count();

        $total_invest_amount       = UserHasInvestPlan::where('user_id',$user->id)->pluck('invest_amount')->sum();
        $complete_invest_amount    = UserHasInvestPlan::where('user_id',$user->id)->where('status',GlobalConst::COMPLETE)->pluck('invest_amount')->sum();
        $ongoing_invest_amount     = UserHasInvestPlan::where('user_id',$user->id)->where('status',GlobalConst::RUNNING)->pluck('invest_amount')->sum();

        $total_profit_amount = InvestmentProfitLog::where('user_id',$user->id)->pluck('profit_amount')->sum();

        // Total Money Transfer
        $total_money_transfer = Transaction::where('user_type',GlobalConst::USER)->where('user_id',$user->id)->where('type',PaymentGatewayConst::TYPETRANSFERMONEY)->pluck('request_amount')->sum();
        $pending_money_transfer = Transaction::pending()->where('user_type',GlobalConst::USER)->where('user_id',$user->id)->where('type',PaymentGatewayConst::TYPETRANSFERMONEY)->pluck('request_amount')->sum();
        $success_money_transfer = Transaction::complete()->where('user_type',GlobalConst::USER)->where('user_id',$user->id)->where('type',PaymentGatewayConst::TYPETRANSFERMONEY)->pluck('request_amount')->sum();

        // Total Invest Plans
        $total_invest_plans = UserHasInvestPlan::where('user_id',$user->id)->count();
        $ongoing_invest_plans = UserHasInvestPlan::where('user_id',$user->id)->where('status',GlobalConst::RUNNING)->count();
        $complete_invest_plans = UserHasInvestPlan::where('user_id',$user->id)->where('status',GlobalConst::COMPLETE)->count();


        return view('admin.sections.user-care.details', compact(
            'page_title',
            'user',
            'user_wallet',
            'user_pending_add_money',
            'user_success_add_money',
            'user_send_total',
            'user_receive_total',
            'user_total_transactions',
            'user_money_out',
            'user_pending_money_out',
            'user_reject_money_out',
            'active_support_ticket',
            'pending_support_ticket',
            'solved_support_ticket',
            'total_invest_amount',
            'complete_invest_amount',
            'ongoing_invest_amount',
            'total_profit_amount',
            'total_money_transfer',
            'pending_money_transfer',
            'success_money_transfer',
            'total_invest_plans',
            'ongoing_invest_plans',
            'complete_invest_plans',
        ));
    }

    public function sendMailUsers(Request $request) {
        $request->validate([
            'user_type'     => "required|string|max:30",
            'subject'       => "required|string|max:250",
            'message'       => "required|string|max:2000",
        ]);

        $users = [];
        switch($request->user_type) {
            case "active";
                $users = User::active()->get();
                break;
            case "all";
                $users = User::get();
                break;
            case "email_verified";
                $users = User::emailVerified()->get();
                break;
            case "kyc_verified";
                $users = User::kycVerified()->get();
                break;
            case "banned";
                $users = User::banned()->get();
                break;
        }

        try{
            Notification::send($users,new SendMail((object) $request->all()));
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }

        return back()->with(['success' => ['Email successfully sended']]);

    }

    public function sendMail(Request $request, $username)
    {
        $request->merge(['username' => $username]);
        $validator = Validator::make($request->all(),[
            'subject'       => 'required|string|max:200',
            'message'       => 'required|string|max:2000',
            'username'      => 'required|string|exists:users,username',
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal","email-send");
        }
        $validated = $validator->validate();
        $user = User::where("username",$username)->first();
        $validated['user_id'] = $user->id;
        $validated = Arr::except($validated,['username']);
        $validated['method']   = "SMTP";
        try{
            UserMailLog::create($validated);
            $user->notify(new SendMail((object) $validated));
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }
        return back()->with(['success' => ['Mail successfully sended']]);
    }

    public function userDetailsUpdate(Request $request, $username)
    {
        $request->merge(['username' => $username]);
        $validator = Validator::make($request->all(),[
            'username'              => "required|exists:users,username",
            'firstname'             => "required|string|max:60",
            'lastname'              => "required|string|max:60",
            'mobile_code'           => "nullable|string|max:10",
            'mobile'                => "nullable|string|max:20",
            'address'               => "nullable|string|max:250",
            'country'               => "nullable|string|max:50",
            'state'                 => "nullable|string|max:50",
            'city'                  => "nullable|string|max:50",
            'zip_code'              => "nullable|numeric|max_digits:8",
            'email_verified'        => 'required|boolean',
            'two_factor_status'     => 'required|boolean',
            'kyc_verified'          => 'required|boolean',
            'status'                => 'required|boolean',
        ]);
        $validated = $validator->validate();
        $validated['address']  = [
            'country'       => $validated['country'] ?? "",
            'state'         => $validated['state'] ?? "",
            'city'          => $validated['city'] ?? "",
            'zip'           => $validated['zip_code'] ?? "",
            'address'       => $validated['address'] ?? "",
        ];
        $validated['mobile_code']       = remove_speacial_char($validated['mobile_code']);
        $validated['mobile']            = remove_speacial_char($validated['mobile']);
        $validated['full_mobile']       = $validated['mobile_code'] . $validated['mobile'];
        if($validated['full_mobile'] == "") $validated['full_mobile'] = null;

        $user = User::where('username', $username)->first();
        if(!$user) return back()->with(['error' => ['Oops! User not exists']]);

        $basic_settings = BasicSettingsProvider::get();

        try{
            if((int) $validated['two_factor_status'] != $user->two_factor_status) {
                $status = ($validated['two_factor_status'] == 1) ? "Enabled" : "Disabled";
                // Need to send mail and notify update
                $data['message'] = $basic_settings->site_name . " " . auth()->user()->getRolesString() . " Updated your Two Factor status to  " . $status;
                $user->notify(new MessageNotification($data));
            }
    
            if((int) $validated['status'] != $user->status) {
                $status = ($validated['status'] == 1) ? "Active" : "Banned";
                // Need to send mail and notify update
                $data['message'] = $basic_settings->site_name . " " . auth()->user()->getRolesString() . " Updated your account status to  " . $status;
                $user->notify(new MessageNotification($data));
            }
    
            if((int) $validated['email_verified'] != $user->email_verified) {
                $status = ($validated['email_verified'] == 1) ? "Verified" : "Unverified";
                // Need to send mail and notify update
                $data['message'] = $basic_settings->site_name . " " . auth()->user()->getRolesString() . " Updated your account mail verification status to  " . $status;
                $user->notify(new MessageNotification($data));
            }
    
            if((int) $validated['kyc_verified'] != $user->kyc_verified) {
                $status = ($validated['kyc_verified'] == 1) ? "Verified" : "Unverified";
                // Need to send mail and notify update
                $data['message'] = $basic_settings->site_name . " " . auth()->user()->getRolesString() . " Updated your account KYC verification status to  " . $status;
                $user->notify(new MessageNotification($data));
            }
        }catch(Exception $e) {
            //handle error
        }

        try {
            $user->update($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }

        return back()->with(['success' => ['Profile Information Updated Successfully!']]);
    }

    public function loginLogs($username)
    {
        $page_title = "Login Logs";
        $user = User::where("username",$username)->first();
        if(!$user) return back()->with(['error' => ['Opps! User doesn\'t exists']]);
        $logs = UserLoginLog::where('user_id',$user->id)->paginate(12);
        return view('admin.sections.user-care.login-logs', compact(
            'logs',
            'page_title',
        ));
    }

    public function mailLogs($username) {
        $page_title = "User Email Logs";
        $user = User::where("username",$username)->first();
        if(!$user) return back()->with(['error' => ['Opps! User doesn\'t exists']]);
        $logs = UserMailLog::where("user_id",$user->id)->paginate(12);
        return view('admin.sections.user-care.mail-logs',compact(
            'page_title',
            'logs',
        ));
    }

    public function loginAsMember(Request $request,$username) {
        $request->merge(['username' => $username]);
        $request->validate([
            'target'            => 'required|string|exists:users,username',
            'username'          => 'required_without:target|string|exists:users',
        ]);

        try{
            $user = User::where("username",$request->username)->first();
            Auth::guard("web")->login($user);
        }catch(Exception $e) {
            return back()->with(['error' => [$e->getMessage()]]);
        }
        return redirect()->intended(route('user.dashboard'));
    }

    public function kycDetails($username) {
        $user = User::where("username",$username)->first();
        if(!$user) return back()->with(['error' => ['Oops! User doesn\'t exists']]);

        $page_title = "KYC Profile";
        return view('admin.sections.user-care.kyc-details',compact("page_title","user"));
    }

    public function kycApprove(Request $request, $username) {
        $request->merge(['username' => $username]);
        $request->validate([
            'target'        => "required|exists:users,username",
            'username'      => "required_without:target|exists:users,username",
        ]);
        $user = User::where('username',$request->target)->orWhere('username',$request->username)->first();
        if($user->kyc_verified == GlobalConst::VERIFIED) return back()->with(['warning' => ['User already KYC verified']]);
        if($user->kyc == null) return back()->with(['error' => ['User KYC information not found']]);

        try{
            $user->update([
                'kyc_verified'  => GlobalConst::APPROVED,
            ]);
        }catch(Exception $e) {
            $user->update([
                'kyc_verified'  => GlobalConst::PENDING,
            ]);
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }
        return back()->with(['success' => ['User KYC successfully approved']]);
    }

    public function kycReject(Request $request, $username) {
        $request->validate([
            'target'        => "required|exists:users,username",
            'reason'        => "required|string|max:500"
        ]);
        $user = User::where("username",$request->target)->first();
        if(!$user) return back()->with(['error' => ['User doesn\'t exists']]);
        if($user->kyc == null) return back()->with(['error' => ['User KYC information not found']]);

        try{
            $user->update([
                'kyc_verified'  => GlobalConst::REJECTED,
            ]);
            $user->kyc->update([
                'reject_reason' => $request->reason,
            ]);
        }catch(Exception $e) {
            $user->update([
                'kyc_verified'  => GlobalConst::PENDING,
            ]);
            $user->kyc->update([
                'reject_reason' => null,
            ]);

            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }

        return back()->with(['success' => ['User KYC information is rejected']]);
    }

    public function search(Request $request) {
        $validator = Validator::make($request->all(),[
            'text'  => 'required|string',
        ]);

        if($validator->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }

        $validated = $validator->validate();
        $users = User::search($validated['text'])->limit(10)->get();
        return view('admin.components.search.user-search',compact(
            'users',
        ));
    }

    public function walletBalanceUpdate(Request $request,$username) {

        $validator = Validator::make($request->all(),[
            'type'      => "required|string|in:add,subtract",
            'wallet'    => "required|numeric|exists:user_wallets,id",
            'amount'    => "required|numeric",
            'remark'    => "nullable|string|max:200",
        ]);
        
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal','wallet-balance-update-modal');
        }

        $validated = $validator->validate();
        $user_wallet = UserWallet::whereHas('user',function($q) use ($username){
            $q->where('username',$username);
        })->find($validated['wallet']);
        if(!$user_wallet) return back()->with(['error' => ['User wallet not found!']]);

        DB::beginTransaction();
        try{

            $user_wallet_balance = 0;
            $action_type = "";

            switch($validated['type']){
                case "add":
                    $action_type = "Added";
                    $user_wallet_balance = $user_wallet->balance + $validated['amount'];
                    DB::table($user_wallet->getTable())->where('id',$user_wallet->id)->increment('balance',$validated['amount']);
                    break;
                case "subtract":
                    $action_type = "Subtract";
                    if($user_wallet->balance >= $validated['amount']) {
                        $user_wallet_balance = $user_wallet->balance - $validated['amount'];
                        DB::table($user_wallet->getTable())->where('id',$user_wallet->id)->decrement('balance',$validated['amount']);
                    }else {
                        return back()->with(['error' => ['User do not have sufficient balance']]);
                    }
                    break;
            }

            DB::table("transactions")->insertGetId([
                'type'              => PaymentGatewayConst::TYPEADDSUBTRACTBALANCE,
                'trx_id'            => generate_unique_string("transactions","trx_id",16),
                'user_type'         => GlobalConst::USER,
                'user_id'           => $user_wallet->user->id,
                'wallet_id'         => $user_wallet->id,
                'request_amount'    => $validated['amount'],
                'request_currency'  => $user_wallet->currency->code,
                'exchange_rate'     => 1,
                'percent_charge'    => 0,
                'fixed_charge'      => 0,
                'total_charge'      => 0,
                'total_payable'     => $validated['amount'],
                'receive_amount'    => $validated['amount'],
                'receiver_type'     => GlobalConst::USER,
                'receiver_id'       => $user_wallet->user->id,
                'available_balance' => $user_wallet_balance,
                'payment_currency'  => $user_wallet->currency->code,
                'remark'            => $validated['remark'],
                'status'            => PaymentGatewayConst::STATUSSUCCESS,
                'created_at'        => now(),
            ]);

            // Send Mail to User
            $from_or_to = ($action_type == "Added") ? "to" : "from";
            $data['message']  = "Your wallet balance updated by ". auth()->user()->getRolesString() .". " . $action_type . " (" . $validated['amount'] . $user_wallet->currency->code . ")  ". $from_or_to . " " . $user_wallet->currency->code . " Wallet Balance";
            $user_wallet->user->notify(new MessageNotification($data));

            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            return back()->with(['error' => ['Transaction failed! '. $e->getMessage()]]);
        }

        return back()->with(['success' => ['Transaction success']]);
    }


    public function referUsers($username) {
        $user = User::where('username',$username)->with(['referUsers' => function($query) {
            $query->with(['user' => function($query) {
                $query->with(['referUsers']);
            }]);
        }])->first();
        if(!$user) abort(404);

        $page_title = "Refer Users";
        return view('admin.sections.user-care.refer-users', compact('user','page_title'));
    }
}
