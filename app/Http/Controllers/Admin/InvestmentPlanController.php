<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Http\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Admin\InvestmentPlan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvestmentPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Investment Plan";
        $investment_plans = InvestmentPlan::orderByDesc("id")->paginate(10);
        return view('admin.sections.invest-plan.index',compact('page_title','investment_plans'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Create New Plan";
        return view('admin.sections.invest-plan.create',compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => "required|string|max:150",
            'title'                 => "nullable|string|max:150",
            'duration'              => "required|integer|digits_between:0,20",
            'profit_return_type'    => "required|in:". GlobalConst::INVEST_PROFIT_DAILY_BASIS . "," . GlobalConst::INVEST_PROFIT_ONE_TIME,
            'min_invest'            => "required|numeric|gt:0",
            'min_invest_offer'      => "nullable|numeric|gte:0",
            'max_invest'            => "required|numeric|gte:" . $request->min_invest,
            'profit_fixed'          => "required|numeric|gte:0",
            'profit_percent'        => "required|numeric|gte:0",
        ]);
        $validated['slug']  = Str::slug($validated['name']);
        if(InvestmentPlan::where('slug',$validated['slug'])->exists()) {
            throw ValidationException::withMessages([
                'name'          => "Name already exists",
            ]);
        }

        if($validated['min_invest_offer'] == null) $validated['min_invest_offer'] = 0;
        
        InvestmentPlan::create($validated);
        
        return to_route('admin.invest.plan.index')->with(['success' => ['New plan created successfully']]);
    }

    public function statusUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'status'                    => 'required|boolean',
            'data_target'               => 'required|string',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }
        $validated = $validator->safe()->all();
        $invest_plan_id = $validated['data_target'];

        $invest_plan = InvestmentPlan::find($invest_plan_id);
        if(!$invest_plan) {
            $error = ['error' => ['Investment Plan Not Found!']];
            return Response::error($error,null,404);
        }

        try{
            $invest_plan->update([
                'status' => ($validated['status'] == true) ? false : true,
            ]);
        }catch(Exception $e) {
            $error = ['error' => ['Something went wrong!. Please try again.']];
            return Response::error($error,null,500);
        }

        $success = ['success' => ['Plan status updated successfully!']];
        return Response::success($success,null,200);
    }

    public function edit(InvestmentPlan $invest_plan) {
        $page_title = "Investment Plan Edit";
        return view('admin.sections.invest-plan.edit',compact('page_title','invest_plan'));
    }

    public function update(Request $request, InvestmentPlan $invest_plan) {
        $validated = $request->validate([
            'name'                  => "required|string|max:150",
            'title'                 => "nullable|string|max:150",
            'duration'              => "required|integer|digits_between:0,20",
            'profit_return_type'    => "required|in:". GlobalConst::INVEST_PROFIT_DAILY_BASIS . "," . GlobalConst::INVEST_PROFIT_ONE_TIME,
            'min_invest'            => "required|numeric|gt:0",
            'min_invest_offer'      => "nullable|numeric|gte:0",
            'max_invest'            => "required|numeric|gte:" . $request->min_invest,
            'profit_fixed'          => "required|numeric",
            'profit_percent'        => "required|numeric",
        ]);

        $validated['slug']  = Str::slug($validated['name']);
        if(InvestmentPlan::whereNot('id',$invest_plan->id)->where('slug',$validated['slug'])->exists()) {
            throw ValidationException::withMessages([
                'name'          => "Name already exists",
            ]);
        }

        $invest_plan->update($validated);

        return to_route('admin.invest.plan.index')->with(['success' => ['Investment Plan Update Successfully']]);
    }   
}
