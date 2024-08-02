<?php

namespace App\Http\Controllers;

use App\Models\Customers;
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
        $plans=Plan::all();
        return view('plan.plan',compact('plans'));
    }
    public function planNameedit(Plan $plan)
    {
        $plans=Plan::all();
        return view('plan.plan', compact('plan','plans'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required',
        ]);

        $name = $request->plan_id . ' MONTHS';
        
       
        Plan::create([
            'plan_id' => $request->plan_id,
            'name' => $name,
        ]);
        return redirect()->back()->with('success', 'Plan created successfully.');
    }
    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'plan_id' => 'required|integer',
        ]);

        // Determine the plan name based on the plan_id
        $name = $request->plan_id . ' MONTHS';

        // Update the plan with the new data
        $plan->update([
            'plan_id' => $request->plan_id,
            'name' => $name,
        ]);

        return redirect()->route('plan.create')->with('success', 'Plan updated successfully.');
    }

    public function planTypeList(){
        $plan=PlanType::all();
        return view('plan.index',compact('plan'));
    }
    public function craeteplanType()
    {
        $plan_types=PlanType::all();
        $plans=Plan::all();
        return view('plan.planType', compact('plans','plan_types'));
    }
    public function planTypedit(PlanType $planType)
    {
        $plan_types=PlanType::all();
        $plans=Plan::all();
        return view('plan.planType', compact('planType','plans','plan_types'));
    }
    public function planTypestore(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'slot_hours' => 'required|regex:/^\d+$/', // Custom validation rule to ensure integer value
        ]);
        $data=$request->all();
        if ($request->image_colour == 'orange') {
            $data['image'] = 'public/img/first-half.svg';
        } elseif ($request->image_colour == 'light_orange') {
            $data['image'] = 'public/img/second-half.svg';
        } else {
            $data['image'] = 'public/img/full-day.svg';
        }
        
        PlanType::create([
            'name' => $data['name'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'slot_hours' => $data['slot_hours'],
            'image' => $data['image'],
        ]);
        return redirect()->route('planType.create')->with('success', 'Plan Type created successfully.');
    }
    public function planTypeupdate(Request $request, PlanType $planType)
    {
        $request->validate([
            'name' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_hours' => 'required|regex:/^\d+$/',
        ]);
        
        $data = $request->all();
        
        if ($request->image_colour == 'orange') {
            $data['image'] = 'public/img/first-half.svg';
        } elseif ($request->image_colour == 'light_orange') {
            $data['image'] = 'public/img/second-half.svg';
        } else {
            $data['image'] = 'public/img/full-day.svg';
        }
        
        // Ensure $planType is defined and is the correct instance
        $planType->update([
            'name' => $data['name'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'slot_hours' => $data['slot_hours'],
            'image' => $data['image'],
        ]);
        
        return redirect()->route('planType.create')->with('success', 'Plan Type updated successfully.');
    }
    public function planPriceList(){
        $planPrice=PlanPrice::leftJoin('plan_types','plan_prices.plan_type_id','=','plan_types.id')->leftJoin('plans','plan_prices.plan_id','=','plans.id')->select('plans.name as plan_name','plan_types.name as plan_type','plan_prices.*')->get();
      
        return view('plan.index',compact('planPrice'));
    }
    public function craeteplanPrice()
    {
        $plans=Plan::all();
        $plantypes=PlanType::all();
        $planPrice_list=PlanPrice::leftJoin('plan_types','plan_prices.plan_type_id','=','plan_types.id')->leftJoin('plans','plan_prices.plan_id','=','plans.id')->select('plans.name as plan_name','plan_types.name as plan_type','plan_prices.*')->get();

        return view('plan.planPrice', compact('plans','plantypes','planPrice_list'));
    }
    public function planPricedit(PlanPrice $planPrice)
    {
        $plans=Plan::all();
        $plantypes=PlanType::all();
        $planPrice_list=PlanPrice::leftJoin('plan_types','plan_prices.plan_type_id','=','plan_types.id')->leftJoin('plans','plan_prices.plan_id','=','plans.id')->select('plans.name as plan_name','plan_types.name as plan_type','plan_prices.*')->get();

        return view('plan.planPrice', compact('planPrice','plans','plantypes','planPrice_list'));
    }
    public function planPricestore(Request $request)
    {
        
        $request->validate([
            'plan_id' => 'required',
            'plan_type_id' => 'required',
            'price' => 'required',
        ]);
        if($request->plan_id){
            PlanPrice::create($request->all());
        }else{
            $plans=Plan::all();
            foreach($plans as $plan){
                $plan_id=$plan->id;
                $plan_type_id=$request->plan_type_id;
                $price=($plan->plan_id) * ($request->price);
                PlanPrice::create([
                    'plan_id'=>$plan_id,
                    'plan_type_id'=>$plan_type_id,
                    'price'=>$price,
                ]);
            }
        }
        
     
       
        return redirect()->route('planPrice.create')->with('success', 'Plan Price created successfully.');
    }
    public function planPriceupdate(Request $request, PlanPrice $planPrice)
    {
        $request->validate([
            'plan_id' => 'required',
            'plan_type_id' => 'required',
            'price' => 'required',
        ]);
        $planPrice->update($request->all());
        return redirect()->route('planPrice.create')->with('success', 'Plan Price updated successfully.');
    }

    public function getPlanType(Request $request){
        $seatId = $request->seat_no_id;
       
        $customer_plan=Customers::where('seat_no', $seatId)->where('id',$request->user_id)
        ->pluck('plan_type_id');
        // Step 1: Retrieve the plan_type_ids from Customers for the given seat
        $filteredPlanTypes=PlanType::where('id',$customer_plan)->pluck('name', 'id');

        $planTypesRemovals = Customers::where('seat_no', $seatId)
            ->pluck('plan_type_id')
            ->toArray();
    
        // Step 2: Retrieve all plan_types as an associative array
        $planTypes = PlanType::pluck('name', 'id');
      
        
      
        // Step 3: Filter out the plan_types that match the retrieved plan_type_ids
        if(!$planTypesRemovals){
                $filteredPlanTypes = $planTypes->reject(function ($name, $id) use ($planTypesRemovals) {
                    return in_array($id, $planTypesRemovals);
                });
            }
   
        // Return the filtered plan types as JSON
        return response()->json($filteredPlanTypes);
    }
    
    
    public function getPrice(Request $request){
        if($request->plan_type_id && $request->plan_id){
            $planId=$request->plan_type_id;
            $PlanpPrice=PlanPrice::where('plan_type_id',$planId)->where('plan_id',$request->plan_id)->pluck('price','id');
            
            return response()->json($PlanpPrice);
        }
    }
    public function getPricePlanwiseUpgrade(Request $request){
        if($request->update_plan_type_id && $request->update_plan_id){
           
            $planId=$request->update_plan_type_id;
            $PlanpPrice=PlanPrice::where('plan_type_id',$planId)->where('plan_id',$request->update_plan_id)->pluck('price','id');
           
            return response()->json($PlanpPrice);
        }
    }
    
    public function getPlanTypeSeatWise(Request $request){
        $seatId = $request->seatId;

        // Step 1: Retrieve the plan_type_ids from Customers for the given seat
        $planTypesRemovals = Customers::where('seat_no', $seatId)
        ->where('status',1)
            ->pluck('plan_type_id')
            ->toArray();

        // Step 2: Retrieve all plan_types as an associative array
        $planTypes = PlanType::pluck('name', 'id');

        // Step 3: Filter out the plan_types that match the retrieved plan_type_ids
        $filteredPlanTypes = $planTypes->reject(function ($name, $id) use ($planTypesRemovals) {
            return in_array($id, $planTypesRemovals);
        });

        // Return the filtered plan types as JSON
        return response()->json($filteredPlanTypes);
    }
    
    

}
