@extends('layouts.admin')

@section('content')

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
                                        <th>F No</th>
                                        <th style="width: 20% ">Name</th>
                                        <th style="width: 8% ">Processed On</th>
                                        <th style="width: 8% ">Starts On</th>
                                        <th style="width: 8% ">Ends On</th>
                                        <th>Amt (Monthly) </th>
                                        <th>Route </th>
                                        <th>Landmark </th>
                                        <th>Paid </th>
                                        <th>Remark</th>
                                        <th>Action</th>
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

<script type="text/javascript">
 $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('student.transportationList') }}",
                lengthMenu: [
                    [10, 50, 100, -1],
                    [10, 50, 100, "All"]
                ],
                columns: [
                    
                    {
                        data: 'form_num',
                        name: 'form_num',
                        searchable: true

                    },
                    {
                        data: 'student_name',
                        name: 'student_name'
                    },

                    {
                        data: 'subscription_start_date',
                        name: 'subscription_start_date',
                       
                    },
                    
                    {
                        data: 'start_date',
                        name: 'start_date',
                        searchable: false
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
                        
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                     
                    },
                    {
                        data: 'route_name',
                        name: 'route_name',
                        
                    },
                    {
                        data: 'landmark',
                        name: 'landmark',
                      
                    },
                    {
                        data: 'van_is_paid',
                        name: 'van_is_paid',
                      
                    },
                    {
                        data: 'remark',
                        name: 'remark',
                      
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },

                ],
                 dom: 'lBfrtip',
                buttons: [
                    'excel', 'csv', 'pdf', 'copy'
                ]
            });

        });
   

</script>


@endsection
