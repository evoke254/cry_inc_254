<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InvestmentProfitLog;

class ProfitLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Profit Log";
        $profit_logs = InvestmentProfitLog::auth()->has('invest')->orderByDesc("id")->paginate(7);
        return view('user.sections.profit-log.index',compact('page_title','profit_logs'));
    }

}
