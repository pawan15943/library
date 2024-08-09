@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="row">
    <div class="col-lg-9">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="dashibox">
                    <h4>Total Enrollments</h4>
                    <div class="d-flex">
                        <h2 class="counter" data-count="{{$total_enrollment}}">{{$total_enrollment}}</h2>
                        <a href="{{route('student.index')}}"><i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashibox">
                    <h4>Total Course Completed</h4>
                    <div class="d-flex">
                        <h2 class="counter" data-count="{{$course_complete}}">{{$course_complete}}</h2>
                        <a href="{{route('student.index')}}"><i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashibox">
                    <h4>Total Certificate Distributed</h4>
                    <div class="d-flex">
                        <h2 class="counter" data-count="{{$certificate_complete}}">{{$certificate_complete}}</h2>
                        <a href="{{route('student.index')}}"><i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashibox">
                    <h4>Booked Seats </h4>
                    <div class="d-flex">
                        <h2 class="counter" data-count="{{$booked_seats}}">{{$booked_seats}}</h2>
                        <a href="{{route('customers.list')}}"><i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashibox">
                    <h4>Available Seats</h4>
                    <div class="d-flex">
                        <h2 class="counter" data-count="{{$availble_seats}}">{{$availble_seats}}</h2>
                        <a href="{{route('seats')}}" class="water-drop-button"><i class="fa-solid fa-arrow-right-long" ></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashibox">
                    <h4>Monthly Revenue</h4>
                    <div class="d-flex">
                        <h2 class="counter" data-count="{{$monthly_revenue}}">{{$monthly_revenue}}</h2>
                        <a href="{{route('admin.accounts')}}"><i class="fa-solid fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="course-list">
            <h4>Course Wise Enrollments</h4>
            <ul>
                @foreach ($count_course_wise as $course)
                <li>
                    <div class="d-flex">
                        <h5>{{$course->course_name }}</h5>
                        <div class="count">{{ $course->student_count }}</div>
                    </div>
                </li>
                @endforeach


            </ul>
        </div>
    </div>
</div>

<div class="row mt-4">
    
    <div class="col-lg-6">
        <div class="course-list">
            <h4>Plan Wise Enrolments</h4>
            <ul>
                @foreach ($planwise_count as $count)
                <li>
                    <div class="d-flex">
                        <h5>{{$count->name }}</h5>
                        <div class="count">{{ $count->customer_count }}</div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="course-list">
            <h4>Course Wise Enrollements</h4>
            
        </div>
    </div>
</div>
<!-- Content Row -->
<div class="row d-none">

    <!-- Total Subscriptions -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1">
                            Full Day User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_fullday}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Subscriptions -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1">
                            First Half User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_firstH}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Subscriptions -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1">Second Half USer
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$count_secondH}}</div>
                            </div>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-uppercase mb-1">Hourly USer
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$count_hourly}}</div>
                            </div>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script>
$(document).ready(function() {
    $('.counter').each(function() {
        var $this = $(this),
            countTo = $this.attr('data-count');

        $({ countNum: $this.text() }).animate({
            countNum: countTo
        },
        {
            duration: 1000,
            easing: 'linear',
            step: function() {
                $this.text(Math.floor(this.countNum));
            },
            complete: function() {
                $this.text(this.countNum);
            }
        });
    });
});
</script>

@endsection