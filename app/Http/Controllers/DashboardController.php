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
            ->groupBy('students.course_id')
            ->get();  
            // $seats=DB::table('seats')->where('is_available','!=',0)->count();          
            return view('admin.index',compact('count_fullday','count_firstH','count_secondH','count_hourly','count_course_wise','planwise_count'));
        }else{
           dd("no");
        }
       
    }
}
