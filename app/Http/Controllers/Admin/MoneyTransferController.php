<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Http\Controllers\Controller;
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
        $page_title = "Transfer Money";
        $logs = Transaction::moneyTransfer()->orderByDesc('id')->paginate(10);

        return view('admin.sections.money-transfer.index',compact(
            'page_title',
            'logs',
        ));
    }

    public function details(Transaction $transaction) {
        $page_title = "Transaction Details";
        return view('admin.sections.money-transfer.details',compact("page_title","transaction"));
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
        $logs = Transaction::moneyTransfer()->search($validated['text'])->limit(10)->get();
        return view('admin.components.search.money-transfer-search',compact(
            'logs',
        ));
    }

    
}
