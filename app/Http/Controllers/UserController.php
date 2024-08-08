<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Plan;
use App\Models\PlanType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(){
         // Fetch seat data and update custor and seat table
         $seats = DB::table('seats')->get();

         foreach($seats as $seat){
             $total_hourse=Customers::where('status', 1)->where('seat_no',$seat->id)->sum('hours');
             DB::table('seats')->where('id', $seat->id)->update(['total_hours' => $total_hourse]);
         }
        //Fetch user data and update seat table and customer table
        $userUpdates = Customers::where('status', 1)->get();
    
        foreach ($userUpdates as $userUpdate) {
            $today = date('Y-m-d'); // Use the correct date format for comparison
            
            // Check if the user's plan has expired
            if ($userUpdate->plan_end_date == $today) {
                // Update status in user table
                $userUpdate->update(['status' => 0]);
                
                // Update seats status
                $seatNo = $userUpdate->seat_no;
                $seat = DB::table('seats')->where('seat_no', $seatNo)->first();
                 //is_available=>available(not booked)=1,not available=0, firstHBook= 2 secondHbook=3 hourly=4 , fullbooked=5 in seat table
                //plan_type_id 1=fullday, 2=firstH, 3=secondH,4=hourly slot 1,5=hourly slot 2, 6=hourly slot 3, 7=hourly slot4 in customer table
                // $totalBookedHours = $seat->total_hours;
                //$remainingHours = 16 - $totalBookedHours;
                
                // update seat availability based on conditions
                $available = 1; // Default to available
                
                if ($seat->is_available == 5) {
                    $available = 1;
                } elseif ($seat->is_available == 4 && ($userUpdate->plan_type_id == 4 || $userUpdate->plan_type_id==5 || $userUpdate->plan_type_id==6 || $userUpdate->plan_type_id==7)) {
                    $available = 1;
                } elseif ($seat->is_available == 3 && $userUpdate->plan_type_id == 3) {
                    $available = 1;
                } elseif ($seat->is_available == 2 && $userUpdate->plan_type_id == 2) {
                    $available = 1;
                } elseif ($seat->is_available == 2 && $userUpdate->plan_type_id == 3) {
                    $available = 2;
                } elseif ($seat->is_available == 3 && $userUpdate->plan_type_id == 2) {
                    $available = 3;
                } else {
                    $available = 1;
                }

                // Update seat availability
                DB::table('seats')->where('seat_no', $seatNo)->update(['is_available' => $available]);
            }
        }

       

        $users = Customers::where('status', 1);
      
        $plans=Plan::get();
        $plan_types=PlanType::get();
        $count_fullday=Customers::where('hours',16)->count();
        $count_firstH=Customers::where('hours',8)->where('plan_type_id',2)->count();
        $count_secondH=Customers::where('hours',8)->where('plan_type_id',3)->count();
        $available=DB::table('seats')->where('is_available',1)->count();
        $not_available=DB::table('seats')->where('is_available',0)->count();
        return view('seat.index', compact('seats', 'users','plans','plan_types','count_fullday','count_firstH','count_secondH','available','not_available'));
    }

    public function seatCreate(){
        return view('seat.create');
    }

    public function seatStore(Request $request)
    {
        $totalSeats = $request->input('total_seats');
    
        if (!$totalSeats || $totalSeats <= 0) {
            return redirect()->back()->with('error', 'Invalid number of seats');
            die;
        }
    
        // Retrieve the last seat number from the seats table
        $lastSeatNo = DB::table('seats')->orderBy('seat_no', 'desc')->value('seat_no');
    
        // If there are no seats yet, start from 1; otherwise, start from the next number
        $startSeatNo = $lastSeatNo ? $lastSeatNo + 1 : 1;
    
        $seats = [];
    
        for ($i = 0; $i < $totalSeats; $i++) {
            $seats[] = [
                'seat_no' => $startSeatNo + $i,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        DB::table('seats')->insert($seats);
    
        return redirect()->route('seats')->with('success', 'Data created successfully.');
    }
    protected function validateCustomer(Request $request, $id = null)
    {
        $rules = [
            'seat_no' => 'required|integer',
            'plan_id' => 'required|integer',
            'plan_type_id' => 'required|integer',
            'plan_price_id' => 'required|integer',
            'id_proof_file' => 'nullable|file|mimes:jpg,png|max:200',
            'mobile' => 'nullable|digits:10', 
            'pin_code' => 'nullable|digits:6',  
        ];

        // If it's an update (i.e., $id is not null), add conditional rules
        if ($id) {
            $validator = Validator::make($request->all(), $rules);
            
            // Conditionally require fields if $id is not null
            $validator->sometimes(['name', 'dob', 'mobile', 'email'], 'required', function ($input) use ($id) {
                return $id !== null;
            });
            
            // Conditionally require 'user_id' if $id is null
            $validator->sometimes('user_id', 'required|integer', function ($input) use ($id) {
                return !$id;
            });

            return $validator;
        }

        // For create, return the validator with basic rules
        return Validator::make($request->all(), $rules);
    }
    protected function seat_availablity(Request $request){
     
        $seat = DB::table('seats')->where('seat_no', $request->seat_no)->first();
        //available(not booked)=1,not available=0, firstHBook= 2 secondHbook=3 hourly=4 , fullbooked=5
                    //plan type 1=fullday, 2=firstH, 3=secondH,4=hourly	
                    // Determine new seat availability based on conditions
                      
        $available=5;
        if( $seat->is_available == 1 && $request->plan_type_id==1 ){
            $available = 5;
        }elseif($seat->is_available == 1 && $request->plan_type_id==2 ){
            $available = 2;
        }elseif($seat->is_available == 1 && $request->plan_type_id==3 ){
            $available = 3;
        }elseif($seat->is_available == 1 && $request->plan_type_id==4 ){
            $available = 4;
        }elseif($seat->is_available == 2 && $request->plan_type_id==3){
            $available = 5;
        }elseif($seat->is_available == 3 && $request->plan_type_id==2){
            $available = 5;
        }elseif($seat->is_available == 4 && ($request->plan_type_id==5 || $request->plan_type_id==6 || $request->plan_type_id==5)){
            $available = 4;
        }
      
        // Update seat availability
        DB::table('seats')->where('seat_no', $request->seat_no)->update(['is_available' => $available]);
    }
    
    public function customerStore(Request $request){
  
        $validator = $this->validateCustomer($request);
        if(Customers::where('seat_no',$request->seat_no)->where('plan_type_id',$request->plan_type_id)->count()>0){
            return response()->json([
                'error' => true,
                'message' => 'This Plan Type Seat already booked'
            ], 422);
            die;
        }
        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
            die;
        }

        // Handle the file upload
    
        if($request->hasFile('id_proof_file'))
        {
            $this->validate($request,['id_proof_file' => 'mimes:webp,png,jpg,jpeg|max:200']);
            $id_proof_file = $request->id_proof_file;
            $id_proof_fileNewName = "id_proof_file".time().$id_proof_file->getClientOriginalName();
            $id_proof_file->move('public/uploade/',$id_proof_fileNewName);
            $id_proof_file = 'public/uploade/'.$id_proof_fileNewName;
        }else{
            $id_proof_file=null;
        }

        if(PlanType::where('id',$request->plan_type_id)->count()>0){
            $hours=PlanType::where('id',$request->plan_type_id)->value('slot_hours');
        }
        if((Customers::where('seat_no',$request->seat_no)->sum('hours') + $hours)>16){
            return response()->json([
                'error' => true,
                'message' => 'You can not select this plan type'
            ], 422);
            die;
        }
    
        $plan_id = $request->input('plan_id');
        $months=Plan::where('id',$plan_id)->value('plan_id');
        $duration = $months ?? 0;

        $start_date = Carbon::parse($request->input('plan_start_date'));
        $endDate = $start_date->copy()->addMonths($duration);
        
        // Create a new customer using mass assignment
        $customer = Customers::create([
            'seat_no' => $request->input('seat_no'),
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),
            'dob' => $request->input('dob'),
            'plan_id' => $plan_id,
            'plan_type_id' => $request->input('plan_type_id'),
            'plan_price_id' => $request->input('plan_price_id'),
            'plan_start_date' =>$start_date->format('Y-m-d'),
            'plan_end_date' => $endDate->format('Y-m-d'),
            'join_date' => date('Y-m-d'),
            'id_proof_name' => $request->input('id_proof_name'),
            'id_proof_file' => $id_proof_file, // Store the file path
            'hours' =>$hours,
            'payment_mode' => $request->input('payment_mode'),
        ]);
        // Update seat availability

        $this->seat_availablity($request);
        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully!',
        ], 201);
    }
    // customer update and upgrade plan function
    public function userUpdate(Request $request, $id = null)
    {
     
        $validator = $this->validateCustomer($request, $id);
       
        if($request->input('user_id')){
            $user_id=$request->input('user_id');

                // Check if the validation fails
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
        }else{
            $user_id=$id;
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
       
        // Find the customer by user_id
        $customer = Customers::findOrFail($user_id);
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.'
            ], 404);
        }

        // Determine hours based on plan_type_id
        if(PlanType::where('id',$request->plan_type_id)->count()>0){
            $hours=PlanType::where('id',$request->plan_type_id)->value('slot_hours');
        }
       
       
        // Calculate new plan_end_date by adding duration to the current plan_end_date
        $months=Plan::where('id',$request->plan_id)->value('plan_id');
        $duration = $months ?? 0;
        $currentEndDate = Carbon::parse($customer->plan_end_date);
        $start_date = Carbon::parse($request->input('plan_start_date'));
        if($request->input('plan_end_date')){
            $newEndDate= Carbon::parse($request->input('plan_end_date'));
        }elseif($start_date){
            $newEndDate = $start_date->copy()->addMonths($duration);
        }else{
            $newEndDate = $currentEndDate->addMonths($duration);
        }
       
        
        // Handle the file upload
        if($request->hasFile('id_proof_file'))
        {
            $this->validate($request,['id_proof_file' => 'mimes:webp,png,jpg,jpeg|max:200']);
            $id_proof_file = $request->id_proof_file;
            $id_proof_fileNewName = "id_proof_file".time().$id_proof_file->getClientOriginalName();
            $id_proof_file->move('public/uploade/',$id_proof_fileNewName);
            $id_proof_file = 'public/uploade/'.$id_proof_fileNewName;
        }else{
            $id_proof_file=null;
        }
        // Update customer details
        $customer->seat_no = $request->input('seat_no');
        $customer->plan_id = $request->input('plan_id');
        $customer->plan_type_id = $request->input('plan_type_id');
        $customer->plan_price_id = $request->input('plan_price_id');
        $customer->name = $request->input('name');
        $customer->mobile = $request->input('mobile');
        $customer->email = $request->input('email');
        if($request->input('plan_start_date')){
            $customer->plan_start_date =$start_date;
        }
       
        $customer->plan_end_date = $newEndDate->toDateString();
        $customer->hours = $hours;
        $customer->id_proof_file = $id_proof_file;
        $customer->save();

        // Update seat availability
        $this->seat_availablity($request);


        if($request->input('user_id')){
            // Return a JSON response
            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully!',
            ], 200);
        }else{
            return redirect('customers/list')->with('success', 'User Update successfully.');
        }
       
    }
    public function custmorList(){
        $customers = Customers::leftJoin('seats', 'customers.seat_no', '=', 'seats.id')
        ->leftJoin('plans', 'customers.plan_id', '=', 'plans.id')
        ->leftJoin('plan_types', 'customers.plan_type_id', '=', 'plan_types.id')
       
        ->select(
            'plan_types.name as plan_type_name',
            'plans.name as plan_name',
            'seats.seat_no','customers.*',
            'plan_types.start_time',
            'plan_types.end_time',
        )
        ->get();
        return view('seat.customer' ,compact('customers'));
    }
    public function seatHistory(){
        $seats = DB::table('seats')->get();
        $customers_seats=Customers::where('status', 1)->get();
       
        return view('seat.seatHistory' ,compact('customers_seats','seats'));
    }
    public function getUser(Request $request, $id = null)
    {
        // Determine the customer ID to use
        $customerId = $request->id ?? $id;

        // Query to get customer details
        $customer = Customers::where('customers.id', $customerId)
            ->leftJoin('seats', 'customers.seat_no', '=', 'seats.id')
            ->leftJoin('plans', 'customers.plan_id', '=', 'plans.id')
            ->leftJoin('plan_types', 'customers.plan_type_id', '=', 'plan_types.id')
            ->select(
                'plan_types.name as plan_type_name',
                'plans.name as plan_name',
                'seats.seat_no',
                'customers.*',
                'plan_types.start_time',
                'plan_types.end_time'
            )
            ->firstOrFail();
           
            $plans = Plan::all();
            $planTypes = PlanType::all();
        // Check the request type or the presence of a parameter to determine the response
        if ($request->expectsJson() || $request->has('id')) {
            return response()->json($customer);
        } else {
            return view('seat.customerShow', compact('customer', 'plans', 'planTypes'));
        }
    }

    public function history($id)
    {
        $customers = Customers::leftJoin('plans', 'customers.plan_id', '=', 'plans.id')
        ->leftJoin('plan_types', 'customers.plan_type_id', '=', 'plan_types.id')
       ->where('customers.seat_no',$id)
       ->where('customers.status',0)
        ->select(
            'plan_types.name as plan_type_name',
            'plans.name as plan_name',
            'customers.*',
            'plan_types.start_time',
            'plan_types.end_time',
        )
        ->get();
        $seat=DB::table('seats')->where('id',$id)->first('seat_no');
        return view('seat.seatHistoryView', compact('customers','seat'));
    }

    public function destroy($id)
    {
        
        $customer = Customers::findOrFail($id);
      
        $customer->delete();
    
        return response()->json(['success' => 'User deleted successfully.']);
    }


}
