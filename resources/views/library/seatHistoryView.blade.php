@extends('layouts.admin')
@section('content')
@php
use App\Models\Customers;
use App\Models\PlanType;
use Carbon\Carbon;
$today = Carbon::today();
@endphp
<div class="container">
    <h1>Customer History for Seat {{ $seat->seat_no }}</h1>
    <a href="{{ route('history.seat.list') }}" class="btn btn-primary mb-3">Back to Seats</a>
    @if($customers->isEmpty())
        <p>No customer history found for this seat.</p>
    @else
    <table class="table table-hover data-table" id="datatable">
        <thead>
            <tr class="text-center">
               
                <th style="width: 20% ">Name</th>
                <th style="width: 20% ">Mobile</th>
                <th style="width: 20% ">Email</th>
                <th style="width: 20% ">Plan</th>
                <th style="width: 20% ">Plan Type</th>
                <th style="width: 20% ">Starts On</th>
                <th style="width: 20% ">Ends On</th>
               
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
               
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
