<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:fee-pending', ['only' => ['index']]);
        $this->middleware('permission:fee-approved', ['only' => ['approvedAccounts']]);
        $this->middleware('permission:fee-rejected', ['only' => ['rejectedAccounts']]);
        $this->middleware('permission:add-payment', ['only' => ['addPayment', 'savePayment', 'addPaymentLocal']]);
        $this->middleware('permission:payment logs', ['only' => ['paymentLog']]);
    }
    public function index(Request $request)
    {
        $accounts =DB::table('subscription_offline_transactions')->where('verified', 0)->whereNull('deleted_at')->get();
      
      
        if ($request->ajax()) {
            return DataTables::of($accounts)
                ->addIndexColumn()
                ->addColumn('student_name', function ($row) {
                   $student_name=Student::where('id',$row->student_id)->value('name');
                        return $student_name;
                })
                ->addColumn('form_no', function ($row) {
                    $form_no=Student::where('id',$row->student_id)->value('form_num');
                         return $form_no;
                 })
                 ->addColumn('month_plan', function ($row) {
                    $month_plan=$row->month_plan;
                         return $month_plan.' months';
                 })
               
                 ->addColumn('monthly_amount', function ($row) {
                    $form_no=Subscription::where('student_id',$row->student_id)->value('amount');
                         return $form_no;
                 })
                ->addColumn('paid_amount', function ($row) {
                    if (isset($row->amount) && !empty($row->amount)) {
                        return 'AED '.$row->amount ;
                    } 

                })
                ->addColumn('transaction_date', function ($row) {
                    return $row->transaction_date;
                })
                ->addColumn('invoice_ref_no', function ($row) {
                    
                    return $row->pay_transaction_id;
                    
                })
                ->addColumn('payment_mode', function ($row) {
                    if ($row->payment_mode) {
                        
                        return $row->payment_mode;
                    } 
                })
                ->addColumn('payment_type', function ($row) {
                    if ($row->payment_type ==1) {
                        return 'Bank Transfer';
                    } elseif($row->payment_type ==2){
                        return 'Cheque';
                    }elseif($row->payment_type ==3){
                        return 'Post dated cheque';
                    }elseif($row->payment_type ==4){
                        return 'POS';
                    }
                })
                ->addColumn('paymentproof', function ($row) {
                    $html = '<a href="' . url('/') . '/public/uploads/transaction_receipt/' . $row->transaction_receipt . '" target="_blank"
                        role="button ">'. $row->pay_transaction_id .'</a>';

                        return $html;
                })

                ->addColumn('verification', function ($row) {
                    $html = '<select name="verification" id="verification" fees_id="' . $row->id . '" pattern="[a-zA-Z0-9]+" class="form-control form-control-sm"><option value="">Select</option><option value="1">Approve</option><option value="2">Reject</option></select>';
                    return $html;
                })
                ->rawColumns(['verification', 'invoice_ref_no', 'paymentproof','paid_amount','student_name','form_no','monthly_amount'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('accounts.index');
    }
    public function addPayment(Request $request)
    {
        $student_details = [];
        $subscription = [];
      
        if ($request->has('form_number') && $request->form_number) {
           
            $student_details = Student::select('countries.name as countries_name', 'cities.name as cities', 'study_centers.name as study_centers', 'students.*','study_centers.code as study_center_code','course_categories.name as coursecategories', 'classes.name as classes')
            ->leftJoin('countries', 'students.country_id', '=', 'countries.id')
            ->leftJoin('cities', 'students.city_id', '=', 'cities.id')
            ->leftJoin('study_centers', 'students.center_id', '=', 'study_centers.id')
            ->leftJoin('classes', 'students.class_id', '=', 'classes.id')
            ->leftJoin('courses', 'students.course_id', '=', 'courses.id')
            ->leftJoin('course_types', 'courses.course_type_id', '=', 'course_types.id')
            ->leftJoin('course_categories', 'courses.category_id', '=', 'course_categories.id')
            ->where("students.form_num", $request->form_number)
            ->first();
         
            $subscription =Subscription::select('subscriptions.*','van_subscription_area_list.name as route_name')->leftJoin('van_subscription_area_list','subscriptions.route_id','=','van_subscription_area_list.id')->where("form_num", $request->form_number)->first();
           
            if (!isset($subscription) ) {
                return redirect()->back()
                    ->with('error', 'Sorry, we could not find the fee information. Please enter correct Form and try again.');
            }

           
        }

        return view('accounts.add-payment', compact('student_details','subscription'));

    }

    public function savePayment(Request $request)
    {
        $rules_arr = [
            'pay_transaction_id' => 'bail|nullable|required_if:payment_type,1',
            'transaction_date' => 'bail|nullable|required_if:payment_type,1|date|date_format:d-m-Y',
            'cheque_number' => 'bail|nullable|required_if:payment_type,2|numeric',
            'cheque_date' => 'bail|nullable|required_if:payment_type,2|date|date_format:d-m-Y',
            'pdc_cheque_number' => 'bail|nullable|required_if:payment_type,3|numeric',
            'pdc_cheque_date' => 'bail|nullable|required_if:payment_type,3|date|date_format:d-m-Y',
            'pos_trxn_no' => 'bail|nullable|required_if:payment_type,4',
            'pos_trxn_date' => 'bail|nullable|required_if:payment_type,4|date|date_format:d-m-Y',
            'transaction_receipt' => 'required|file',
            'payType'=>'required',
            'total_amount'=>'required',
        ];

        // Define custom messages
        $messages = [
            'pay_transaction_id.required_if' => 'The Transaction Number/ Reference Number field is required',
            'transaction_date.required_if' => 'The Transaction Date field is required',
            'transaction_date.date' => 'Please Provide a Date',
            'transaction_date.date_format' => 'Transaction Date is not in a valid format',
            'cheque_number.required_if' => 'The cheque number field is required',
            'cheque_date.required_if' => 'The cheque date field is required',
            'pdc_cheque_number.required_if' => 'The cheque number field is required',
            'pdc_cheque_date.required_if' => 'The cheque date field is required',
            'pos_trxn_no.required_if' => 'The Transaction Id field is required',
            'pos_trxn_date.required_if' => 'The Transaction Date field is required',
            'transaction_receipt.required' => 'The Customer payment proof is required',
            'transaction_receipt.file' => 'The Customer payment proof must be a file',
            'payType.required' => 'Months is required',
        ];

        // Validate the request
        $request->validate($rules_arr, $messages);
      
        $month_plan=$request->payType;
        $subscription=Subscription::where('student_id',$request->student_id)->first();
        $start_date=$subscription->start_date;
        $end_date=$subscription->end_date;
     
        if ($start_date == null) {
            $update_start_date = Carbon::now();
        } else {
         
            $start_date = Carbon::parse($start_date);
            $update_start_date = $start_date;
        }
        
        if ($end_date == null) {
            $update_end_date = Carbon::now()->addMonths($month_plan);
        } else {
            $end_date = Carbon::parse($end_date);
            $update_end_date = $end_date->addMonths($month_plan);
        }
       
        $amount=$request->total_amount ;
        if ($request->payment_type == 1) {
            $pay_transaction_id = $request->pay_transaction_id;
            $cheque_number = null;
            $cheque_date = null;
            $transaction_date = $request->transaction_date ? (Carbon::parse($request->transaction_date))->format('Y-m-d') : null;
           
        } elseif ($request->payment_type == 2) {
            $cheque_number = $request->cheque_number;
            $cheque_date = Carbon::parse($request->cheque_date)->format('Y-m-d');
            $pay_transaction_id = $request->cheque_number;
            $transaction_date = $request->cheque_date ? Carbon::parse($request->cheque_date)->format('Y-m-d') : null;
        } elseif ($request->payment_type == 3) {
            $pay_transaction_id = $request->pdc_cheque_number;
            $cheque_number = $request->pdc_cheque_number;
            $cheque_date = $request->pdc_cheque_date ? Carbon::parse($request->pdc_cheque_date)->format('Y-m-d') : null;
            $transaction_date = Carbon::parse($request->pdc_cheque_date)->format('Y-m-d');
        } elseif ($request->payment_type == 4) {
            $pay_transaction_id = $request->pos_trxn_no;
            $cheque_number = null;
            $cheque_date = null;
            $transaction_date = $request->pos_trxn_date ? Carbon::parse($request->pos_trxn_date)->format('Y-m-d') : null;

        } 

            $iconImageFile = $request->file('transaction_receipt');
            $iconfilename = $iconImageFile->getClientOriginalName();
            $icontmpFilePath = $iconImageFile->getPathname();
            $iconImageMimeType = $iconImageFile->getClientMimeType();
            $iconimage = new \CURLFile($icontmpFilePath, $iconImageMimeType, $iconfilename);
   
      
        $arr_post = [
            'student_id' => $request->student_id,
            'amount' => $amount,
            'pay_transaction_id' =>$pay_transaction_id,
            'payment_mode' =>"offline",
            'transaction_date' => $transaction_date ,
            'payment_type' => $request->payment_type,
            'card_type' => $request->card_type,
            'iban_num' => $request->iban_num,
            'swift_code' => $request->swift_code,
            'account_num' =>  $request->account_num,
            'account_holder_name' => $request->account_holder_name,
            'bank_name' => $request->bank_name,
            'bank_branch' =>$request->bank_branch,
            'cheque_number' => $cheque_number,
            'cheque_date' => $cheque_date,
            'encashment_date' => $request->encashment_date ? Carbon::parse($request->encashment_date)->format('Y-m-d') : null,
            'card_number' => $request->card_number,
            'issuing_bank' => $request->issuing_bank,
            'expiry_date' => $request->expiry_date ? Carbon::parse($request->expiry_date)->format('Y-m-d') : null,
            'transaction_receipt' => $iconimage,
            'month_plan'=>$month_plan,
        ];
      
        if(strtolower($request->payment_mode) == 'offline'){
            $existRecord = DB::table('subscription_offline_transactions')->where('pay_transaction_id',$request->pay_transaction_id)->where('payment_type',$request->payment_type)->count();
            if($existRecord > 0)
            {
                $return['status'] = false;
                $return['code'] = 400;
                $return['message'] = "Fee already added";
                $return['version'] = "1.0";
                $return['data'] =  [];
                return  $return;
            }
        }
        if($request->has('transaction_receipt')){
            $image = $request->file('transaction_receipt');
            $avatarName = time().'.'.$image->getClientOriginalExtension();
            $request->transaction_receipt->move(public_path('/uploads/transaction_receipt'), $avatarName);
            $arr_post['transaction_receipt'] = $avatarName;
        }

        try {
            // Insert the offline transaction and get the ID
            $offline_transaction_id = DB::table('subscription_offline_transactions')->insertGetId($arr_post);
        
            if ($offline_transaction_id) {
                // Update the subscription details
                Subscription::where('student_id', $request->student_id)->update([
                    'subscription_plan' => $subscription->subscription_plan + $month_plan,
                    'start_date' => $update_start_date->format('Y-m-d'),
                    'end_date' => $update_end_date->format('Y-m-d'),
                    'van_isPaid' => 1
                ]);
        
                // Retrieve the paid amount
                $paid_amount = DB::table('subscription_offline_transactions')->where('id', $offline_transaction_id)->value('amount');
        
                // Prepare the student subscription data
                $student_sub = [
                    'student_id' => $request->student_id,
                    'subscription_type' => $month_plan,
                    'paid_amount' => $paid_amount,
                    'transaction_id' => 0,
                    'offline_transaction_id' => $offline_transaction_id,
                    'transaction_date' => $transaction_date,
                    'created_at' => Carbon::now(), // Add created_at timestamp
                    'updated_at' => Carbon::now()  // Add updated_at timestamp
                ];
        
               
                DB::table('students_subscription_fees')->insert($student_sub);

                return redirect()->route('admin.accounts_payment')
                    ->with('success', 'Fee info successfully added');
            } else {
                return redirect()->route('admin.accounts_payment')
                    ->with('error', 'Something went wrong');
            }
       
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error adding fee info: ' . $e->getMessage());
        
            // Redirect with error message
            return redirect()->route('admin.accounts_payment')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function verifyStatus(Request $request)
    {

        DB::beginTransaction();
        try {
           
            $response = DB::table('subscription_offline_transactions')->where('id', $request->id)->update(['verified' => $request->status]);
            $st_update = DB::table('students_subscription_fees')->where('offline_transaction_id', $request->id)->update(['verified' => $request->status]);
            $responsed = DB::table('subscription_offline_transactions')->where('id', $request->id)->first();
            $transaction=DB::table('students_subscription_fees')->where('offline_transaction_id', $request->id)->first();
            if ($request->status == 1 && $responsed && $transaction) {
               
                $student_data=Student::where('id',$transaction->student_id)->first();
                $subscriptions=DB::table('subscriptions')->where('student_id',$transaction->student_id)->first();
                $totalAmountQueryBuilder = DB::table('students_subscription_fees')->where('student_id',$transaction->student_id)->sum('paid_amount');

                $send_data['data']=$student_data;
                $send_data['transactiondate']=$responsed->transaction_date;
                $send_data['paid_amount']=$transaction->paid_amount;
                $send_data['payment_mode']=$responsed->payment_mode;
                $send_data['invoice_ref_no']=$responsed->pay_transaction_id;
                $send_data['total_amount']=$totalAmountQueryBuilder;
                $send_data['start_date']=$subscriptions->start_date;
                $send_data['end_date']=$subscriptions->end_date;
                $send_data['monthly_amount']=$subscriptions->amount;
                $send_data['month']=$responsed->month_plan;
               
                $pdf = PDF::loadView('student.mailPdf', $send_data); 
                $pdf_name = time().'_'.$request->id.".pdf";
              
                $publicPath = str_replace('\\', '/', realpath(public_path()));
                $pdf->save($publicPath . "/allpdf/" . $pdf_name);
                
                $return_path= url('/allpdf/'.$pdf_name);
                $return_array=array("path"=>$return_path,"name"=>$pdf_name,"status_code"=>"200");
                $is_receipt = DB::table('students_subscription_fees')->where('offline_transaction_id', $request->id)->update(['acknowledgement_receipt' => $return_path]);
              
                
            }

            DB::commit();
            return response()->json([
                'message' => 'Status Updated',
                'success' => 1,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return response()->json([
                'message' => "Something went wrong",
                'error' => 1,
            ]);
        }
    }

    public function approveAccountList(Request $request){
        $accounts =DB::table('students_subscription_fees')->where('verified', 1)->whereNull('deleted_at')->get();
      
      
        if ($request->ajax()) {
            return DataTables::of($accounts)
                ->addIndexColumn()
                ->addColumn('student_name', function ($row) {
                   $student_name=Student::where('id',$row->student_id)->value('name');
                        return $student_name;
                })
                ->addColumn('form_no', function ($row) {
                    $form_no=Student::where('id',$row->student_id)->value('form_num');
                         return $form_no;
                 })
                 ->addColumn('month_plan', function ($row) {
                    $month_plan=$row->subscription_type;
                         return $month_plan.' months';
                 })
               
                 ->addColumn('monthly_amount', function ($row) {
                    $form_no=Subscription::where('student_id',$row->student_id)->value('amount');
                         return $form_no;
                 })
                ->addColumn('paid_amount', function ($row) {
                    if (isset($row->paid_amount) && !empty($row->paid_amount)) {
                        return 'AED '.$row->paid_amount ;
                    } 

                })
                ->addColumn('transaction_date', function ($row) {
                    return $row->transaction_date;
                })
                ->addColumn('invoice_ref_no', function ($row) {
                    
                    return $row->pay_transaction_id;
                    
                })
                ->addColumn('payment_mode', function ($row) {
                    if ($row->transaction_id!=0) {
                        
                        return 'Online';
                    } else{
                        return 'Offline';
                    }
                })
                ->addColumn('payment_type', function ($row) {
                    if($row->transaction_id!=0){
                        $payment_type=DB::table('subscription_transactions')->where('id',$row->transaction_id)->value('payment_type');
                        return $payment_type;
                    }else{
                        $payment_typ=DB::table('subscription_offline_transactions')->where('id',$row->offline_transaction_id)->value('payment_type');
                        if ($payment_typ ==1) {
                            return 'Bank Transfer';
                        } elseif($payment_typ ==2){
                            return 'Cheque';
                        }elseif($payment_typ ==3){
                            return 'Post dated cheque';
                        }elseif($payment_typ ==4){
                            return 'POS';
                        }
                    }
                    
                })
               

                ->addColumn('verification', function ($row) {
                    return 'Approved';
                    
                })
                ->rawColumns(['verification', 'invoice_ref_no', 'paid_amount','student_name','form_no','monthly_amount'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('accounts.approve');
    }
    public function rejectAccountList(Request $request){
        $accounts =DB::table('students_subscription_fees')->where('verified', 1)->whereNull('deleted_at')->get();
      
      
        if ($request->ajax()) {
            return DataTables::of($accounts)
                ->addIndexColumn()
                ->addColumn('student_name', function ($row) {
                   $student_name=Student::where('id',$row->student_id)->value('name');
                        return $student_name;
                })
                ->addColumn('form_no', function ($row) {
                    $form_no=Student::where('id',$row->student_id)->value('form_num');
                         return $form_no;
                 })
                 ->addColumn('month_plan', function ($row) {
                    $month_plan=$row->subscription_type;
                         return $month_plan.' months';
                 })
               
                 ->addColumn('monthly_amount', function ($row) {
                    $form_no=Subscription::where('student_id',$row->student_id)->value('amount');
                         return $form_no;
                 })
                ->addColumn('paid_amount', function ($row) {
                    if (isset($row->paid_amount) && !empty($row->paid_amount)) {
                        return 'AED '.$row->paid_amount ;
                    } 

                })
                ->addColumn('transaction_date', function ($row) {
                    return $row->transaction_date;
                })
                ->addColumn('invoice_ref_no', function ($row) {
                    
                    return $row->pay_transaction_id;
                    
                })
                ->addColumn('payment_mode', function ($row) {
                    if ($row->transaction_id!=0) {
                        
                        return 'Online';
                    } else{
                        return 'Offline';
                    }
                })
                ->addColumn('payment_type', function ($row) {
                    if($row->transaction_id!=0){
                        $payment_type=DB::table('subscription_transactions')->where('id',$row->transaction_id)->value('payment_type');
                        return $payment_type;
                    }else{
                        $payment_typ=DB::table('subscription_offline_transactions')->where('id',$row->offline_transaction_id)->value('payment_type');
                        if ($payment_typ ==1) {
                            return 'Bank Transfer';
                        } elseif($payment_typ ==2){
                            return 'Cheque';
                        }elseif($payment_typ ==3){
                            return 'Post dated cheque';
                        }elseif($payment_typ ==4){
                            return 'POS';
                        }
                    }
                    
                })
               

                ->addColumn('verification', function ($row) {
                    $html = 'Rejected';
                    return $html;
                })
                ->rawColumns(['verification', 'invoice_ref_no', 'paid_amount','student_name','form_no','monthly_amount'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('accounts.approve');
    }

    
}
