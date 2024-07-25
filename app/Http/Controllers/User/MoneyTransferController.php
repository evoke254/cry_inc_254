<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Models\Admin\Currency;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Constants\PaymentGatewayConst;
use App\Models\Admin\TransactionSetting;
use App\Providers\Admin\CurrencyProvider;
use Illuminate\Support\Facades\Validator;

class MoneyTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Money Transfer";
        $money_transfer_settings = TransactionSetting::transfer()->first();
        return view('user.sections.money-transfer.index',compact('page_title','money_transfer_settings'));
    }

    public function submit(Request $request) {

        $validated = Validator::make($request->all(),[
            'sender_amount'     => "required|numeric|gt:0",
            'receiver'          => "required|string",
        ])->validate();

        $default_currency = CurrencyProvider::default();

        $sender_wallet = UserWallet::auth()->whereHas("currency",function($q) use ($default_currency) {
            $q->where("code",$default_currency->code)->active();
        })->active()->first();

        if(!$sender_wallet) return back()->with(['error' => ['Your wallet isn\'t available with currency ('.$default_currency->code.')']]);

        $receiver_currency = Currency::receiver()->active()->where('code',$default_currency->code)->first();
        if(!$receiver_currency) return back()->with(['error' => ['Currency ('.$validated['receiver_currency'].') isn\'t available for receive any transaction']]);
        
        $trx_charges = TransactionSetting::where("slug",GlobalConst::TRANSFER)->first();
        $charges = $this->transferCharges($validated['sender_amount'],$trx_charges,$sender_wallet,$receiver_currency);

        // Check transaction limit
        $sender_currency_rate = $sender_wallet->currency->rate;
        $min_amount = $trx_charges->min_limit * $sender_currency_rate;
        $max_amount = $trx_charges->max_limit * $sender_currency_rate;
        if($charges['sender_amount'] < $min_amount || $charges['sender_amount'] > $max_amount) {
            return back()->with(['error' => ['Please follow the transaction limit. (Min '.$min_amount . ' ' . $sender_wallet->currency->code .' - Max '.$max_amount. ' ' . $sender_wallet->currency->code . ')']]);
        }

        $field_name = "username";
        if(check_email($validated['receiver'])) {
            $field_name = "email";
        }
        
        $receiver = User::notAuth()->where($field_name,$validated['receiver'])->active()->first();
        if(!$receiver) return back()->with(['error' => ['Receiver doesn\'t exists or Receiver is temporary banned']]);

        $receiver_wallet = UserWallet::where("user_id",$receiver->id)->whereHas("currency",function($q) use ($receiver_currency){
            $q->receiver()->where("code",$receiver_currency->code);
        })->first();

        if(!$receiver_wallet) return back()->with(['error' => ['Receiver wallet not available']]);
        
        if($charges['payable'] > $sender_wallet->balance) return back()->with(['error' => ['Your wallet balance is insufficient']]);
        
        // Check Daily Transaction Limit
        // $user_daily_total_transactions = Transaction::where('user_id',$sender_wallet->user->id)->transferMoney()->send()->today()->get()->map(function($item) {
        //     $data = [
        //         'default_currency_amount'   => ($item->request_amount / $item->details->charges->sender_currency_rate),
        //     ];
        //     return $data;
        // })->sum('default_currency_amount');

        // dd($user_daily_total_transactions);

        // if(($user_daily_total_transactions + $charges['default_currency_amount']) > $trx_charges->daily_limit) {
        //     return back()->with(['warning' => ['Your daily transaction limit is over. You can transaction maximum ' . get_amount($trx_charges->daily_limit,$default_currency->code) . '. You already completed ' . get_amount($user_daily_total_transactions,$default_currency->code) . ' equal money.']]);
        // }

        // // Check Monthly Transaction Limit
        // $user_monthly_total_transactions = Transaction::where('user_id',$sender_wallet->user->id)->transferMoney()->send()->whereBetween('created_at',[now()->firstOfMonth(),now()->lastOfMonth()])->get()->map(function($item) {
        //     $data = [
        //         'default_currency_amount'   => ($item->request_amount / $item->details->charges->sender_currency_rate),
        //     ];
        //     return $data;
        // })->sum('default_currency_amount');

        // if(($user_monthly_total_transactions + $charges['default_currency_amount']) > $trx_charges->monthly_limit) {
        //     return back()->with(['warning' => ['Your monthly transaction limit is over. You can transaction maximum ' . get_amount($trx_charges->monthly_limit,$default_currency->code) . '. You already completed ' . get_amount($user_monthly_total_transactions,$default_currency->code) . ' equal money.']]);
        // }

        // Transaction Start
        DB::beginTransaction();
        try{
            $trx_id = generate_unique_string("transactions","trx_id",16);
            // Sender TRX
            $inserted_id = DB::table("transactions")->insertGetId([
                'type'              => PaymentGatewayConst::TYPETRANSFERMONEY,
                'trx_id'            => $trx_id,
                'user_type'         => GlobalConst::USER,
                'user_id'           => $sender_wallet->user->id,
                'wallet_id'         => $sender_wallet->id,
                'request_amount'    => $charges['sender_amount'],
                'request_currency'  => $receiver_wallet->currency->code,
                'exchange_rate'     => $default_currency->rate,
                'percent_charge'    => $charges['percent_charge'],
                'fixed_charge'      => $charges['fixed_charge'],
                'total_charge'      => $charges['total_charge'],
                'total_payable'     => $charges['payable'],
                'receive_amount'    => $charges['receiver_amount'],
                'receiver_type'     => GlobalConst::USER,
                'receiver_id'       => $receiver_wallet->user->id,
                'available_balance' => $sender_wallet->balance - $charges['payable'],
                'payment_currency'  => $sender_wallet->currency->code,
                'details'           => json_encode(['receiver_username'=> $receiver_wallet->user->username,'sender_username'=> $sender_wallet->user->username]),
                'status'            => GlobalConst::SUCCESS,
                'created_at'        => now(),
            ]);

            $sender_wallet->balance -= $charges['payable'];
            $sender_wallet->save();

            $receiver_wallet->balance += $charges['receiver_amount'];
            $receiver_wallet->save();
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            return redirect()->route('user.money.transfer.index')->with(['error' => ['Transaction failed! Something went wrong! Please try again']]);
        }

        return redirect()->route('user.money.transfer.index')->with(['success' => ['Successfully money transfer to @'.$receiver_wallet->user->username.' success']]);
    }

    public function transferCharges($sender_amount,$charges,$sender_wallet,$receiver_currency) {
        $exchange_rate = $receiver_currency->rate / $sender_wallet->currency->rate;

        $data['exchange_rate']              = $exchange_rate;
        $data['sender_amount']              = $sender_amount;
        $data['sender_currency']            = $sender_wallet->currency->code;
        $data['receiver_amount']            = $sender_amount * $exchange_rate;
        $data['receiver_currency']          = $receiver_currency->code;
        $data['percent_charge']             = ($sender_amount / 100) * $charges->percent_charge ?? 0;
        $data['fixed_charge']               = $sender_wallet->currency->rate * $charges->fixed_charge ?? 0;
        $data['total_charge']               = $data['percent_charge'] + $data['fixed_charge'];
        $data['sender_wallet_balance']      = $sender_wallet->balance;
        $data['payable']                    = $sender_amount + $data['total_charge'];
        $data['default_currency_amount']    = ($sender_amount / $sender_wallet->currency->rate);
        $data['sender_currency_rate']       = $sender_wallet->currency->rate;
        return $data;
    }
}
