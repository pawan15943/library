@extends('layouts.admin')
@section('content')

<!-- Content Header (Page header) -->

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

                            <table class="table table-hover border data-table" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 20% ">Seat No.</th>
                                        <th style="width: 20% ">Name</th>
                                        <th style="width: 20% ">Mobile Number</th>
                                        <th style="width: 20% ">Email</th>
                                        <th style="width: 20% ">Plan Name</th>
                                        <th style="width: 20% ">Plan Type</th>
                                        <th style="width: 20% ">Starts On</th>
                                        <th style="width: 20% ">Expired On</th>
                                        <th style="width: 20% ">Action</th>
                                    </tr>


                                </thead>
                                <tbody>
                                  
                                   
                                    @foreach($customers as $key => $value)
                                    <tr class="text-center">
                                        <td style="width: 20% "> {{$value->seat_no}}</td>
                                        <td style="width: 20% "> {{$value->name}}</td>
                                        <td style="width: 20% "> {{$value->mobile}}</td>
                                        <td style="width: 20% "> {{$value->email }}</td>
                                        <td style="width: 20% "> {{$value->name}}</td>
                                        <td style="width: 20% "> {{$value->seat_no}}</td>
                                        <td style="width: 20% "> {{$value->plan_start_date}}</td>
                                        <td style="width: 20% "> {{$value->plan_end_date}}</td>
                                        <td style="width: 20% "><a href="#" class="btn tooltips btn-default p-2 btn-sm rounded " title="Edit Route"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn tooltips btn-default p-2 btn-sm rounded" title="Edit Route"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn tooltips btn-default p-2 btn-sm rounded" title="Edit Route"><i class="fas fa-trash"></i></a>
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

<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>


@endsection