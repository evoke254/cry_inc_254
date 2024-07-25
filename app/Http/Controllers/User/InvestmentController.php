<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "My Investments";
        $user = auth()->user();
        $investments = $user->investPlans()->orderByDesc("id")->paginate(10);
        return view('user.sections.my-invest.index',compact('page_title','investments','user'));
    }

}
