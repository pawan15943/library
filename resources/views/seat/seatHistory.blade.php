@extends('layouts.admin')
@section('content')

@php
use App\Models\Customers;
use App\Models\PlanType;
use Carbon\Carbon;
$today = Carbon::today();
@endphp

<!-- Content Header (Page header) -->
<!-- Main row -->
<div class="row">
    <!-- Main Info -->
    <div class="col-lg-12">
        <!-- Add Document -->
        <div class="card card-default main_card_content border-0">
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive tableRemove_scroll">
                            <table class="table table-hover table-bordered" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 10%">Seat No.</th>
                                        <th style="width: 40%">Name</th>
                                        <th style="width: 10%">Plan Type</th>
                                        <th style="width: 10%">Join On</th>
                                        <th style="width: 10%">Start On</th>
                                        <th style="width: 10%">Ends On</th>
                                        <th style="width: 15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($seats as $seat)
                                    @php
                                    $usersForSeat = App\Models\Customers::where('seat_no', $seat->seat_no)->get();
                                    @endphp
                                    @if($usersForSeat->count() > 0)
                                    <tr class="text-center">
                                        <td rowspan="{{ $usersForSeat->count() }}">{{ $seat->seat_no }}</td>
                                        @foreach($usersForSeat as $user)
                                            @php
                                                $plantype = App\Models\PlanType::where('id', $user->plan_type_id)->first();
                                                $endDate = Carbon::parse($user->plan_end_date);
                                                $diffInDays = $today->diffInDays($endDate, false);
                                            @endphp
                                            @if (!$loop->first)
                                            <tr class="text-center">
                                            @endif
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $plantype->name }}</td>
                                            <td>{{ $user->join_date }}
                                                @if ($diffInDays > 0)
                                                <small class="text-success fs-10">Expires in {{ $diffInDays }} days</small>
                                                @elseif ($diffInDays < 0)
                                                    <small class="text-danger fs-10">Expired {{ abs($diffInDays) }} days ago</small>
                                                @else
                                                    <small class="text-warning fs-10">Expires today</small>
                                                @endif
                                            </td> 
                                            <td>{{ $user->plan_start_date }}</td>
                                            <td>{{ $user->plan_end_date }}</td>
                                            @if ($loop->first)
                                            <td rowspan="{{ $usersForSeat->count() }}">
                                                <ul class="actionables">
                                                    <li>
                                                        <a href="{{$seat->id}}" class="btn tooltips btn-default p-2 btn-sm rounded" title="View Seat"><i class="fas fa-eye"></i></a>
                                                    </li>
                                                </ul>
                                            </td>
                                            @endif
                                            @if (!$loop->first)
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tr>
                                    @endif
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
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>
<!-- /.row (main row) -->
@endsection