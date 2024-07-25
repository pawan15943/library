@extends('layouts.admin')
@section('content')

@php
use App\Models\Customers;
@endphp

<!-- Content Header (Page header) -->
<!-- Main row -->
<div class="row">
    <!-- Main Info -->
    <div class="col-lg-12">
        <!-- Add Document -->
        <div class="card card-default main_card_content">
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
                                        <th style="width: 10%">Join On</th>
                                        <th style="width: 10%">Duration</th>
                                        <th style="width: 10%">Start On</th>
                                        <th style="width: 10%">Ends On</th>
                                        <th style="width: 15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($seats as $seat)
                                    @php
                                    $usersForSeat = Customers::where('seat_no', $seat->seat_no)->get();
                                    @endphp
                                    @if($usersForSeat->count() > 0)
                                    <tr class="text-center">
                                        <td rowspan="{{ $usersForSeat->count() }}">{{ $seat->seat_no }}</td>
                                        @foreach($usersForSeat as $user)
                                        @if (!$loop->first)
                                    <tr class="text-center">
                                        @endif
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->join_date }}</td>
                                        <td>{{ $user->join_date }}</td>
                                        <td>{{ $user->plan_start_date }}</td>
                                        <td>{{ $user->plan_end_date }}</td>
                                        <td>
                                            <ul class="actionables">
                                                <li><a href="#" class="btn tooltips btn-default p-2 btn-sm rounded " title="Edit Route"><i class="fas fa-edit"></i></a></li>
                                                <li>
                                                    <a href="#" class="btn tooltips btn-default p-2 btn-sm rounded" title="Edit Route"><i class="fas fa-eye"></i></a>
                                                </li>
                                                <li><a href="#" class="btn tooltips btn-default p-2 btn-sm rounded" title="Edit Route"><i class="fas fa-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
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