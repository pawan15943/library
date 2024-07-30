@extends('layouts.admin')
@section('content')

<!-- Content Header (Page header) -->
@php
      use Carbon\Carbon;
@endphp
<!-- Main row -->
<div class="row ">
    <!-- Main Info -->
    <div class="col-lg-12 ">

        <!-- Add Document -->
        <div class="card card-default main_card_content">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive tableRemove_scroll mt-2">
                            <table class="table table-hover data-table" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 20% ">Seat</th>
                                        <th style="width: 20% ">Name</th>
                                        <th style="width: 20% ">Mobile</th>
                                        <th style="width: 20% ">Email</th>
                                        <th style="width: 20% ">Plan</th>
                                        <th style="width: 20% ">Plan Type</th>
                                        <th style="width: 20% ">Starts On</th>
                                        <th style="width: 20% ">Ends On</th>
                                        <th style="width: 20% ">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $key => $value)
                                    @php
                                       
                                         $today = Carbon::today();
                                        $endDate = Carbon::parse($value->plan_end_date);
                                        $diffInDays = $today->diffInDays($endDate, false);
                                    @endphp
                                    <tr class="text-center">
                                        <td > {{$value->seat_no}}</td>
                                        <td style="width: 20%;"> <span class="truncate">{{$value->name}}</span></td>
                                        <td> {{$value->mobile}}</td>
                                        <td> {{$value->email }}</td>
                                        <td> {{$value->plan_name}}</td>
                                        <td style="width: 15%;"> {{$value->plan_type_name}}</td>
                                        <td style="width: 10%;"> {{$value->plan_start_date}}</td>
                                        <td style="width: 13%;"> {{$value->plan_end_date}}
                                            @if ($diffInDays > 0)
                                            <small class="text-success fs-10">Expires in {{ $diffInDays }} days</small>
                                            @elseif ($diffInDays < 0)
                                                <small class="text-danger fs-10">Expired {{ abs($diffInDays) }} days ago</small>
                                            @else
                                                <small class="text-warning fs-10">Expires today</small>
                                            @endif
                                           
                                        </td>
                                        <td style="width: 20%;">
                                            <ul class="actionables">
                                                <li><a href="#" class="btn tooltips btn-default p-2 btn-sm rounded " title="Edit Route"><i class="fas fa-edit"></i></a></li>
                                                <li>
                                                <a href="#" class="btn tooltips btn-default p-2 btn-sm rounded" title="Edit Route"><i class="fas fa-eye"></i></a></li>
                                                <li><a href="#" class="btn tooltips btn-default p-2 btn-sm rounded" title="Edit Route"><i class="fas fa-trash"></i></a></li>
                                            </ul>
                                            
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