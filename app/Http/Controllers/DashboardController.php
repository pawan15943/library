<?php

namespace App\Http\Controllers;

use App\Models\Customers;
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
            
            return view('admin.index',compact('count_fullday','count_firstH','count_secondH','count_hourly'));
        }else{
           dd("no");
        }
       
    }
}
