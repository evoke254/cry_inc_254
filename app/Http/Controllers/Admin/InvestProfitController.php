<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestmentProfitLog;
use Illuminate\Http\Request;

class InvestProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Investment Profits";

        $logs = InvestmentProfitLog::orderByDesc("id")->paginate(12);
        return view('admin.sections.invest-profit.index',compact('page_title','logs'));
    }

}
