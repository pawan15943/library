@extends('layouts.admin') 
@section('content') 


<!-- Main row -->
<div class="row">
    <!-- Main Info -->
    <div class="col-lg-12 ">

        <!-- Add Document -->
        <div class="card card-default main_card_content" id="generalInfo ">

            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="table-responsive tableRemove_scroll mt-2">
                            <table class="table table-hover border data-table" id="datatable">
                                <thead>
                                    <tr class="text-center">

                                        <th style="width: 20% ">Student Name</th>
                                        <th>Mobile No. </th>
                                        <th>Email </th>
                                        <th>City</th>
                                        <th>Course</th>
                                        <th>Course Type</th>
                                        <th>Total Fees</th>
                                        <th>Total Paid</th>
                                        <th>Total Pending</th>
                                        
                                        <th style="width: 20% ">Make Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $key => $value)
                                    @php
                                        $course=App\Models\Course::where('id', $value->course_id)->select('course_fees')->first();
                                        $total_fees=$course->course_fees;
                                        $transaction=App\Models\Transaction::where('student_id',$value->id)->orderBy('id','DESC')->first();
                                        if($transaction){
                                            $pending_amount=$transaction->pending_amount;
                                        }else{
                                            $pending_amount=$total_fees;
                                        }
                                        $get_tran=App\Models\Transaction::where('student_id',$value->id)->get();
                                        if($get_tran){
                                            $paid_amount= $get_tran->sum('paid_amount');
                                        }else{
                                            $paid_amount=0;
                                        }
                                    @endphp
                                    <tr class="text-center">
                                        <td class="uppercase">{{$value->name}}</td>
                                        <td>{{$value->mobile}}</td>
                                        <td>{{$value->email}}</td>
                                        <td>{{$value->city_name}}</td>
                                        <td>{{$value->course_name}}</td>
                                        <td>{{$value->course_type}}</td>
                                       
                                        <td>{{$total_fees}}</td>
                                        <td>{{$paid_amount}}</td>
                                        <td>{{$pending_amount}}</td>
                                        <td>
                                            <a href="{{ route('admin.accounts_payment', $value->id) }}" class="btn btn-primary button"> <i class="fas fa-credit-card"></i> &nbsp; Pay Now</a>
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

    </div>

</div>
<!-- /.row (main row) -->

<!-- /.content -->

@endsection
