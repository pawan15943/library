@extends('layouts.admin')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Main row -->
<div class="row ">
    <!-- Main Info -->
    <div class="col-lg-12 ">

        <!-- Add Document -->
        <div class="card card-default main_card_content" id="generalInfo ">
            
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="table-responsive tableRemove_scroll mt-2">
                            <table class="table table-hover border data-table trspotation_data" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th>Form No</th>
                                        <th>Name</th>
                                        <th>Invoice No</th>
                                        <th>Subscription Duration</th>
                                        {{-- <th>Amt (Monthly)</th> --}}
                                        <th>Amt Paid</th>
                                        <th>Payment Date</th>
                                        <th>Payment Mode</th>
                                        <th>Payment Type</th>
                                        <th>Verify Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
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
@php
    $current_route = Route::currentRouteName();
    $route=route($current_route);
@endphp
<script type="text/javascript">
$(document).ready(function() {
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ $route }}",
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
            columns: [
                
                {
                    data: 'form_no',
                    name: 'form_no',
                    searchable: true
                },
                {
                    data: 'student_name',
                    name: 'student_name'
                },
                 
                {
                    data: 'invoice_ref_no',
                    name: 'invoice_ref_no',
                },
                {
                    data: 'month_plan',
                    name: 'month_plan',
                },
                // {
                //     data: 'monthly_amount',
                //     name: 'monthly_amount',
                // },
            
                {
                    data: 'paid_amount',
                    name: 'paid_amount',
                },
                {
                    data: 'transaction_date',
                    name: 'transaction_date',
                },
               
               
                {
                    data: 'payment_mode',
                    name: 'payment_mode',
                },
                {
                    data: 'payment_type',
                    name: 'payment_type,'
                },
               
                {
                    data: 'verification',
                    name: 'verification',
                }
            ],
                dom: 'lBfrtip',
            buttons: [
                'excel', 'csv', 'pdf', 'copy'
            ]
        });

    });
  
   
});
</script>


@endsection
