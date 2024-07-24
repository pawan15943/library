<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanPrice;
use App\Models\PlanType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
       
        $plan=Plan::all();
        return view('plan.index',compact('plan'));
    }
    public function craetePlanName()
    {
        
        return view('plan.plan');
    }
    public function planNameedit(Plan $plan)
    {
        
        return view('plan.plan', compact('plan'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required',
        ]);

        switch ($request->plan_id) {
            case 1:
                $name = 'Monthly';
                break;
            case 3:
                $name = 'Quarterly';
                break;
            case 6:
                $name = 'HalfYearly';
                break;
            case 12:
                $name = 'Yearly';
                break;
            default:
                $name = $request->plan_id . ' Months';
                break;
        }
        
       
        Plan::create([
            'plan_id' => $request->plan_id,
            'name' => $name,
        ]);
        return redirect()->route('plan.index')->with('success', 'Plan created successfully.');
    }
    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'plan_id' => 'required|integer',
        ]);

        // Determine the plan name based on the plan_id
        switch ($request->plan_id) {
            case 1:
                $name = 'Monthly';
                break;
            case 3:
                $name = 'Quarterly';
                break;
            case 6:
                $name = 'HalfYearly';
                break;
            case 12:
                $name = 'Yearly';
                break;
            default:
                $name = $request->plan_id . ' Months';
                break;
        }

        // Update the plan with the new data
        $plan->update([
            'plan_id' => $request->plan_id,
            'name' => $name,
        ]);

        return redirect()->route('plan.index')->with('success', 'Plan updated successfully.');
    }

    public function planTypeList(){
        $plan=PlanType::all();
        return view('plan.index',compact('plan'));
    }
    public function craeteplanType()
    {
        $plans=Plan::all();
        return view('plan.planType', compact('plans'));
    }
    public function planTypedit(PlanType $planType)
    {
        $plans=Plan::all();
        return view('plan.planType', compact('planType','plans'));
    }
    public function planTypestore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'slot_hours' => 'required|regex:/^\d+$/', // Custom validation rule to ensure integer value
        ]);
       
        PlanType::create($request->all());
        return redirect()->route('planType.index')->with('success', 'Plan Type created successfully.');
    }
    public function planTypeupdate(Request $request, PlanType $planType)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $planType->update($request->all());
        return redirect()->route('planType.index')->with('success', 'Plan Type updated successfully.');
    }
    public function planPriceList(){
        $planPrice=PlanPrice::leftJoin('plan_types','plan_prices.plan_type_id','=','plan_types.id')->leftJoin('plans','plan_prices.plan_id','=','plans.id')->select('plans.name as plan_name','plan_types.name as plan_type','plan_prices.*')->get();
      
        return view('plan.index',compact('planPrice'));
    }
    public function craeteplanPrice()
    {
        $plans=Plan::all();
        $plantypes=PlanType::all();
        return view('plan.planPrice', compact('plans','plantypes'));
    }
    public function planPricedit(PlanPrice $planPrice)
    {
        $plans=Plan::all();
        $plantypes=PlanType::all();
        return view('plan.planPrice', compact('planPrice','plans','plantypes'));
    }
    public function planPricestore(Request $request)
    {
        
        $request->validate([
            'plan_id' => 'required',
            'plan_type_id' => 'required',
            'price' => 'required',
        ]);
     
        PlanPrice::create($request->all());
        return redirect()->route('planPrice.index')->with('success', 'Plan Price created successfully.');
    }
    public function planPriceupdate(Request $request, PlanPrice $planPrice)
    {
        $request->validate([
            'plan_id' => 'required',
            'plan_type_id' => 'required',
            'price' => 'required',
        ]);
        $planPrice->update($request->all());
        return redirect()->route('planPrice.index')->with('success', 'Plan Price updated successfully.');
    }

    public function getPlanType(Request $request){
        if($request->plan_id){
            $planId=$request->plan_id;
            $PlanType=PlanType::where('plan_id',$planId)->pluck('name','id');
            
            return response()->json($PlanType);
        }
    }
    public function getPrice(Request $request){
        if($request->plan_type_id){
            $planId=$request->plan_type_id;
            $PlanpPrice=PlanPrice::where('plan_type_id',$planId)->pluck('price','id');
            
            return response()->json($PlanpPrice);
        }
    }
    

}
