<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ReferralLevelPackage;
use App\Models\ReferredUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Refer Level";
        $auth_user = Auth::user();
        $referral_levels = ReferralLevelPackage::orderBy("id","ASC")->get();
        $refer_users = ReferredUser::where('refer_user_id', $auth_user->id)->with(['user' => function($query) {
            $query->with(['referUsers']);
        }])->paginate(10);
        return view('user.sections.refer-level.index',compact('page_title','auth_user','referral_levels','refer_users'));
    }
}
