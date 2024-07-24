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
                'plan_type' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        DB::table('seats')->insert($seats);
    
        return redirect()->route('seats')->with('success', 'Data created successfully.');
    }
    public function customerStore(Request $request){
  
        $validator = Validator::make($request->all(), [
            'seat_no' => 'required|integer',
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'plan_id' => 'required|integer',
            'plan_type_id' => 'required|integer',
            'plan_start_date' => 'required|date',
          
            'plan_price_id' => 'required',
        
            // 'id_proof_file' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
            die;
        }

        // Handle the file upload
        if ($request->hasFile('id_proof_file')) {
            $file = $request->file('id_proof_file');
            $filePath = $file->store('id_proofs', 'public');
        }else{
            $filePath=null;
        }
        if($request->plan_type_id==1){
            $hours=16;
        }elseif($request->plan_type_id==2 || $request->plan_type_id==3){
            $hours=8;
        }elseif($request->plan_type_id==4 || $request->plan_type_id==5 || $request->plan_type_id==6 || $request->plan_type_id==7){
            $hours=4;
        }
        $planDurations = [
            1 => 1,   // 1 month
            2 => 2,   // 2 months
            3 => 3,   // 3 months
            4 => 4,   // 4 months
            5 => 5,   // 5 months
            6 => 6,   // 6 months
            7 => 12   // 1 year
        ];
    
        $plan_id = $request->input('plan_id');
        $duration = $planDurations[$plan_id] ?? 0;

        $start_date = Carbon::parse($request->input('plan_start_date'));
      
        $endDate = $start_date->addMonths($duration);
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
            'id_proof_name' => $request->input('id_proof_name'),
            'id_proof_file' => $filePath, // Store the file path
            'hours' =>$hours,
            'payment_mode' => $request->input('payment_mode'),
        ]);
        $seat = DB::table('seats')->where('seat_no', $request->seat_no)->first();
        //available(not booked)=1,not available=0, firstHBook= 2 secondHbook=3 hourly=4 , fullbooked=5
                    //plan type 1=fullday, 2=firstH, 3=secondH,4=hourly	
                    // Determine new seat availability based on conditions
    
        if( $seat->is_available == 1 && $request->plan_type_id==1 ){
            $available = 5;
        }elseif($seat->is_available == 1 && $request->plan_type_id==2 ){
            $available = 2;
        }elseif($seat->is_available == 1 && $request->plan_type_id==3 ){
            $available = 3;
        }elseif($seat->is_available == 1 && $request->plan_type_id==4 ){
            $available = 4;
        }else{
            $available = 4;
        }
        
        // Update seat availability
        DB::table('seats')->where('seat_no', $request->seat_no)->update(['is_available' => $available]);
        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully!',
        ], 201);
    }
    
    public function custmorList(){
        $customers=Customers::get();
        return view('seat.customer' ,compact('customers'));
    }
    public function seatHistory(){
        $seats = DB::table('seats')->get();
        $customers_seats=Customers::where('status', 1)->get();
       
        return view('seat.seatHistory' ,compact('customers_seats','seats'));
    }
    public function geUser(Request $request){
       
        $customer_seats = Customers::where('customers.id', $request->id)
        ->leftJoin('seats', 'customers.seat_no', '=', 'seats.id')
        ->leftJoin('plans', 'customers.plan_id', '=', 'plans.id')
        ->leftJoin('plan_types', 'customers.plan_type_id', '=', 'plan_types.id')
        ->leftJoin('plan_prices', 'customers.plan_price_id', '=', 'plan_prices.id')
        ->select(
            'plan_types.name as plan_type_name',
            'plan_prices.price as price',
            'plans.name as plan_name',
            'seats.seat_no','customers.*'
        )
        ->first();
       
        return response()->json($customer_seats);
    }
   

    public function userUpdate(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'seat_no' => 'required|integer',
            'user_id' => 'required|integer',
            'plan_id' => 'required|integer',
            'plan_type_id' => 'required|integer',
            'plan_price_id' => 'required|integer',
           
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the customer by user_id
        $customer = Customers::find($request->input('user_id'));
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.'
            ], 404);
        }

        // Determine hours based on plan_type_id
        if ($request->plan_type_id == 1) {
            $hours = 16;
        } elseif ($request->plan_type_id == 2 || $request->plan_type_id == 3) {
            $hours = 8;
        } elseif ($request->plan_type_id == 4) {
            $hours = 4;
        }
        if($request->plan_id == 1){
            $duration=1;
        }elseif($request->plan_id == 2){
            $duration=2;
        }elseif($request->plan_id == 3){
            $duration=3;
        }elseif($request->plan_id == 4){
            $duration=4;
        }elseif($request->plan_id == 5){
            $duration=5;
        }elseif($request->plan_id == 6){
            $duration=6;
        }elseif($request->plan_id == 7){
            $duration=12;
        }

        // Calculate new plan_end_date by adding duration to the current plan_end_date
        $currentEndDate = Carbon::parse($customer->plan_end_date);
        $newEndDate = $currentEndDate->addMonths($duration);

        // Update customer details
        $customer->seat_no = $request->input('seat_no');
        $customer->plan_id = $request->input('plan_id');
        $customer->plan_type_id = $request->input('plan_type_id');
        $customer->plan_price_id = $request->input('plan_price_id');
        $customer->plan_end_date = $newEndDate->toDateString();
        $customer->hours = $hours;
        $customer->save();

        // Update seat availability
        $seat = DB::table('seats')->where('seat_no', $request->seat_no)->first();
        //available(not booked)=1,not available=0, firstHBook= 2 secondHbook=3 hourly=4 , fullbooked=5
        //plan type 1=fullday, 2=firstH, 3=secondH,4=hourly    
        // Determine new seat availability based on conditions

        if ($seat->is_available == 1 && $request->plan_type_id == 1) {
            $available = 5;
        } elseif ($seat->is_available == 1 && $request->plan_type_id == 2) {
            $available = 2;
        } elseif ($seat->is_available == 1 && $request->plan_type_id == 3) {
            $available = 3;
        } elseif ($seat->is_available == 1 && $request->plan_type_id == 4) {
            $available = 4;
        } else {
            $available = 4;
        }

        // Update seat availability
        DB::table('seats')->where('seat_no', $request->seat_no)->update(['is_available' => $available]);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully!',
        ], 200);
    }

    

}
