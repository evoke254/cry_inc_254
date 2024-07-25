<?php

namespace App\Http\Controllers\User;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Transactions";
        $transaction_logs = Transaction::where(function($q) {
            $q->where('user_type',GlobalConst::USER)->orWhere('receiver_type',GlobalConst::USER);
        })->where(function($q) {
            $q->where('user_id',auth()->user()->id)->orWhere('receiver_id',auth()->user()->id);
        })->orderByDesc('id')->paginate(10);
        return view('user.sections.transaction.index',compact('page_title','transaction_logs'));
    }

}
