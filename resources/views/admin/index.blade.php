@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="row g-4">
    <div class="col-lg-4">
        <div class="dashibox">
            <h4>Total Enrollments</h4>
            <div class="d-flex">
                <h2>1202</h2>
                <a href=""><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="dashibox">
            <h4>Total Course Completed</h4>
            <div class="d-flex">
                <h2>15</h2>
                <a href=""><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="dashibox">
            <h4>Total Certificate Distributed</h4>
            <div class="d-flex">
                <h2>10</h2>
                <a href=""><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="dashibox">
            <h4>Booked Seats </h4>
            <div class="d-flex">
                <h2>10</h2>
                <a href=""><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="dashibox">
            <h4>Available Seats</h4>
            <div class="d-flex">
                <h2>10</h2>
                <a href=""><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="dashibox">
            <h4>Monthly Revenue</h4>
            <div class="d-flex">
                <h2>10</h2>
                <a href=""><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-6">

        <div class="course-list">
            <h4>Course Wise Enrollments</h4>
            <ul>
                <li>
                    <div class="d-flex">
                        <h5>Advanced Computer Course</h5>
                        <div class="count">15</div>
                    </div>
                </li>
                <li>
                    <div class="d-flex">
                        <h5>RSCIT</h5>
                        <div class="count">10</div>
                    </div>
                </li>
                <li>
                    <div class="d-flex">
                        <h5>TALLY PRIME</h5>
                        <div class="count">20</div>
                    </div>
                </li>
                <li>
                    <div class="d-flex">
                        <h5>AI Specilist</h5>
                        <div class="count">18</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-lg-6">

        <div class="course-list">
            <h4>Plan Wise Enrolments</h4>
            <ul>
                <li>
                    <div class="d-flex">
                        <h5>Full Day</h5>
                        <div class="count">15</div>
                    </div>
                </li>
                <li>
                    <div class="d-flex">
                        <h5>First Half</h5>
                        <div class="count">10</div>
                    </div>
                </li>
                <li>
                    <div class="d-flex">
                        <h5>Second Half</h5>
                        <div class="count">20</div>
                    </div>
                </li>
                <li>
                    <div class="d-flex">
                        <h5>Hourly</h5>
                        <div class="count">18</div>
                    </div>
                </li>
            </ul>
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



@endsection