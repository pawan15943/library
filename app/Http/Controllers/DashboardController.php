<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Student;
use Illuminate\Http\Request;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user=Auth::user();
       
        if ($user->hasRole('Super Admin')) {
            
            $count_fullday=Customers::where('hours',16)->count();
            $count_firstH=Customers::where('hours',8)->where('plan_type_id',2)->count();
            $count_secondH=Customers::where('hours',8)->where('plan_type_id',3)->count();
            $count_hourly=Customers::where('hours',4)->count();
            $planwise_count = Customers::leftJoin('plan_types', 'customers.plan_type_id', '=', 'plan_types.id')
            ->select('plan_types.name', DB::raw('COUNT(customers.id) as customer_count'))
            ->groupBy('plan_types.name')
            ->get();   
            $count_course_wise = Student::leftJoin('courses', 'students.course_id', '=', 'courses.id')
            ->select('courses.course_name', DB::raw('COUNT(students.id) as student_count'))
            ->groupBy('courses.course_name')
            ->get();  
            // $seats=DB::table('seats')->where('is_available','!=',0)->count(); 
            $total_enrollment=Student::count();        
            $course_complete=Student::where('status',0)->count();        
            $certificate_complete=Student::where('is_certificate',1)->count();  
            $booked_seats=DB::table('seats')->where('is_available','!=',1)->count();      
            $availble_seats=DB::table('seats')->where('is_available','=',1)->count(); 
            $monthly_revenue = DB::table('transactions')
            ->whereMonth('paid_date', date('m'))
            ->whereYear('paid_date', date('Y'))
            ->sum('paid_amount');            
            return view('admin.dashboard',compact('count_fullday','count_firstH','count_secondH','count_hourly','count_course_wise','planwise_count','total_enrollment','course_complete','certificate_complete','booked_seats','availble_seats','monthly_revenue'));
        }else{
           dd("no");
        }
       
    }
}
