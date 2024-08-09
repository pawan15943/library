@extends('layouts.admin')
@section('content')

<!-- Main content -->

@php
use App\Models\Customers;
$fullDayCount = 0;
$halfDayFirstHalfCount = 0;
$halfDaySecondHalfCount = 0;
$hourlyCount = 0;
@endphp
<div id="success-message" class="alert alert-success" style="display:none;"></div>
<div id="error-message" class="alert alert-danger" style="display:none;"></div>
<div class="row justify-content-center">
    <div class="col-lg-12">
        {{-- <ul class="main-box">
                
                @foreach($seats as $seat)
                    @php
                        $fullDayHours = 16;
                        $halfDayHours = 8;
                        $hourlySlotHours = 4;

                        // Assuming 'total_hours' is the total hours booked for this seat
                        $bookedHours = $seat->total_hours;
                        $remainingHours = $fullDayHours - $bookedHours;

                        // Calculate available positions
                        $halfDayAvailable = $remainingHours >= $halfDayHours ? 2 : 0; // 2 slots for half-day
                        $hourlyAvailable = $remainingHours >= $hourlySlotHours ? 4 : 0; // 4 slots for hourly

                        // Fetch users who booked this seat
                        $usersForSeat = Customers::where('seat_no', $seat->id)->select('id', 'seat_no', 'plan_type_id')->get();

                        // Initialize counters for booked slots
                        $halfDayBookedFirstHalf = 0;
                        $halfDayBookedSecondHalf = 0;
                        $hourlyBookedCount = 0;
                        
                        foreach ($usersForSeat as $customer) {
                            if ($customer->plan_type_id == 2) {
                                $halfDayBookedFirstHalf++;
                                $halfDayFirstHalfCount++;
                            } elseif ($customer->plan_type_id == 3) {
                                $halfDayBookedSecondHalf++;
                                $halfDaySecondHalfCount++;
                            } elseif (in_array($customer->plan_type_id, [4, 5, 6, 7])) {
                                $hourlyBookedCount++;
                                $hourlyCount++;
                            }
                        }

                        $isFullDayBooked = $usersForSeat->contains(fn($customer) => $customer->plan_type_id == 1);
                        $isHalfDayBooked = $usersForSeat->contains(fn($customer) => $customer->plan_type_id == 2 || $customer->plan_type_id == 3);
                        $isHourlyBooked = $usersForSeat->contains(fn($customer) => in_array($customer->plan_type_id, [4, 5, 6, 7]));
                    @endphp

                    <li>

                        @if($isFullDayBooked)
                            <div class="seat second_popup" id="{{ $seat->id }}">
        <div class="number">{{ $seat->id }}</div>
        <img src="{{ asset('public/img/full-day.svg') }}" alt="seat" class="seat_svg">
    </div>
    @elseif($isHalfDayBooked)
    <div class="seat second_popup d-none" id="{{ $seat->id }}">
        <div class="details ">
            T: {{ $halfDayAvailable }} <br> FH: {{ $halfDayBookedFirstHalf }} B <br> SH: {{ $halfDayBookedSecondHalf }} A
        </div>
    </div>
    @if($halfDayAvailable > 0)
    <ul class="inner-seats">
        @for ($i = 0; $i < 2; $i++) <li>
            <div class="seat {{ $i < $halfDayBookedFirstHalf ? 'booked second_popup' : 'available first_popup' }}" id="{{ $seat->id }}">
                <div class="number">{{ $i }}</div>
                <img src="{{ asset($i < $halfDayBookedFirstHalf ? 'public/img/full-day.svg' : 'public/img/available.svg') }}" alt="seat" class="seat_svg">
            </div>
            </li>
            @endfor
    </ul>
    @endif
    @if($halfDayAvailable == 0)
    <ul class="inner-seats">
        @for ($i = 0; $i < 2; $i++) <li>
            <div class="seat {{ $i < $halfDayBookedFirstHalf ? 'booked second_popup' : 'available first_popup' }}" id="{{ $seat->id }}">
                <div class="number">{{ $i }}</div>
                <img src="{{ asset($i < $halfDayBookedFirstHalf ? 'public/img/full-day.svg' : 'public/img/available.svg') }}" alt="seat" class="seat_svg">
            </div>
            </li>
            @endfor
    </ul>
    @endif
    @elseif($isHourlyBooked)
    <div class="seat second_popup d-none" id="{{ $seat->id }}">
        <div class="details ">
            T: {{ $hourlyAvailable }} | H: {{ $hourlyBookedCount }} B
        </div>
    </div>
    @if($hourlyAvailable > 0)
    <ul class="inner-seats">
        @for ($i = 0; $i < 4; $i++) <li>
            <div class="seat {{ $i < $hourlyBookedCount ? 'booked second_popup' : 'available first_popup' }}" id="{{ $seat->id }}">
                <div class="number">{{ $i }}</div>
                <img src="{{ asset($i < $hourlyBookedCount ? 'public/img/full-day.svg' : 'public/img/available.svg') }}" alt="seat" class="seat_svg">
            </div>
            </li>
            @endfor
    </ul>
    @endif
    @if($hourlyAvailable == 0)
    <ul class="inner-seats">
        @for ($i = 0; $i < 4; $i++) <li>
            <div class="seat {{ $i < $hourlyBookedCount ? 'booked second_popup' : 'available first_popup' }}" id="{{ $seat->id }}">
                <div class="number">{{ $i }}</div>
                <img src="{{ asset($i < $hourlyBookedCount ? 'public/img/full-day.svg' : 'public/img/available.svg') }}" alt="seat" class="seat_svg">
            </div>
            </li>
            @endfor
    </ul>
    @endif
    @else
    <div class="seat first_popup" id="{{ $seat->id }}">
        <div class="number">{{ $seat->id }}</div>
        <img src="{{ asset('public/img/available.svg') }}" alt="seat" class="seat_svg">
    </div>
    @endif
    </li>
    @endforeach
    </ul> --}}
    <div class="seat-booking">
    <div class="seat-booking">
    @foreach($seats as $seat)
    <div class="seat_no">
        @php
        $usersForSeat = Customers::where('seat_no', $seat->id)->select('id','seat_no','plan_type_id')->where('status',1)->get();
        $remainingHours = 16 - $seat->total_hours;
        $seatCount = 0;
        $halfday = 1;
        $hourly = 1;

        // Determine seatCount based on remaining hours and availability
        if ($remainingHours == 12 && $seat->is_available == 4) {
            $seatCount = 3;
        } elseif ($remainingHours == 8 && $seat->is_available == 4) {
            $seatCount = 2;
        } elseif ($remainingHours == 4 && $seat->is_available == 4) {
            $seatCount = 1;
        } elseif ($remainingHours == 8 && $seat->is_available != 4) {
            $seatCount = 1;
        } elseif ($remainingHours == 0 && $seat->is_available != 4) {
            $seatCount = 0;
        }
        @endphp

        @if($usersForSeat->count() > 0)
            @foreach($usersForSeat as $user)
                @if($user->plan_type_id == 1)
                    <div class="seat second_popup" id="{{ $user->id }}">
                        <div class="number">{{ $user->seat_no }}</div>
                        <img src="{{ asset('public/img/full-day.svg') }}" alt="seat" class="seat_svg">
                    </div>
                @elseif($user->plan_type_id == 2)
                    <div class="seat hourly_wise second_popup" id="{{ $user->id }}">
                        <div class="number">{{ $halfday++ }}</div>
                        <img src="{{ asset('public/img/first-half.svg') }}" alt="seat" class="seat_svg">
                    </div>
                @elseif($user->plan_type_id == 3)
                    <div class="seat hourly_wise second_popup" id="{{ $user->id }}">
                        <div class="number">{{ $halfday++ }}</div>
                        <img src="{{ asset('public/img/second-half.svg') }}" alt="seat" class="seat_svg">
                    </div>
                @elseif(in_array($user->plan_type_id, [4, 5, 6, 7]))
                    <div class="seat hourly_wise second_popup" id="{{ $user->id }}">
                        <div class="number">{{ $hourly++ }}</div>
                        <img src="{{ asset('public/img/hourly.svg') }}" alt="seat" class="seat_svg">
                    </div>
                @endif
            @endforeach

            @php
                // Adjust seatCount if one half-day and one hourly booking exist
                $halfDayBookings = $usersForSeat->where('plan_type_id', 2)->count() + $usersForSeat->where('plan_type_id', 3)->count();
                $hourlyBookings = $usersForSeat->whereIn('plan_type_id', [4, 5, 6, 7])->count();
                if ($halfDayBookings == 1 && $hourlyBookings == 1) {
                    $seatCount = 1;
                }
            @endphp

            @for ($i = 0; $i < $seatCount; $i++)
                <div class="seat hourly_wise first_popup" id="{{ $seat->id }}">
                    <div class="number">{{ $hourly++ }}</div>
                    <img src="{{ asset('public/img/available.svg') }}" alt="seat" class="seat_svg">
                </div>
            @endfor
        @else
            <div class="seat first_popup" id="{{ $seat->id }}">
                <div class="number">{{ $seat->seat_no }}</div>
                <img src="{{ asset('public/img/available.svg') }}" alt="seat" class="seat_svg">
            </div>
        @endif
    </div>
    @endforeach

</div>



</div>

<div class="d-flex color_lable">
    <div class="full-day">
        <span></span> Full Day ({{$count_fullday}})
    </div>
    <div class="first-half">
        <span></span> First Half ({{$count_firstH}})
    </div>
    <div class="second-half">
        <span></span> Second Half ({{$count_secondH}})
    </div>
    <div class="available">
        <span></span> Hourly ({{$available}})
    </div>
    <div class="not-available">
        <span></span> Available ({{$available}})
    </div>
</div>

</div>
</div>

<!-- /.content -->
<!-- Booking Popup -->
<div class="modal fade" id="seatAllotmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div id="success-message" class="alert alert-success" style="display:none;"></div>
        <div class="modal-content">
            <div id="error-message" class="alert alert-danger" style="display:none;"></div>
            <div id="validation-error-message" class="alert alert-danger" style="display:none;"></div>
            <div class="modal-body ">
                <form id="seatAllotmentForm">
                    <div class="detailes">

                        <button type="button" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                        <h3 id="seat_no_head"></h3>

                        <input type="hidden" class="form-control char-only" name="seat_no" value="" id="seat_no">
                        <div class="row g-3 mt-1">
                            <div class="col-lg-6">
                                <label for="">Full Name <span>*</span></label>
                                <input type="text" class="form-control char-only" placeholder="Full Name" name="name" id="name">
                            </div>
                            <div class="col-lg-6">
                                <label for="">DOB <span>*</span></label>
                                <input type="date" class="form-control" placeholder="Plan Starts On" name="dob" id="dob">
                            </div>
                            <div class="col-lg-6">
                                <label for="">Mobile Number <span>*</span></label>
                                <input type="text" class="form-control digit-only" maxlength="10" minlength="10" placeholder="Mobile Number" name="mobile" id="mobile">
                            </div>
                            <div class="col-lg-6">
                                <label for="">Email Id <span>*</span></label>
                                <input type="text" class="form-control" placeholder="Email Id" name="email" id="email">
                            </div>

                            <div class="col-lg-4">
                                <label for="">Select Plan <span>*</span></label>
                                <select name="" id="plan_id" class="form-control" name="plan_id">
                                    <option value="">Select Plan</option>
                                    @foreach($plans as $key => $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="">Plan Type <span>*</span></label>
                                <select id="plan_type_id" class="form-control" name="plan_type_id">
                                    <option value="">Select Plan Type</option>
                                    {{-- @foreach($plan_types as $key => $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="">Plan Price <span>*</span></label>
                                <input id="plan_price_id" class="form-control" name="plan_price_id" @readonly(true)>

                            </div>
                            <div class="col-lg-4">
                                <label for="">Plan Starts On <span>*</span></label>
                                <input type="date" class="form-control" placeholder="Plan Starts On" name="plan_start_date" id="plan_start_date">
                            </div>


                            <div class="col-lg-4">
                                <label for="">Payment Mode <span>*</span></label>
                                <select name="payment_mode" id="payment_mode" class="form-control">
                                    <option value="">Select Payment Mode</option>
                                    <option value="1">Online</option>
                                    <option value="2">Offline</option>
                                    <option value="3">Pay Later</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="">Id Proof Received <span>*</span></label>
                                <select name="" id="id_proof_name" class="form-control" name="id_proof_name">
                                    <option value="">Select Id Proof</option>
                                    <option value="1">Aadhar</option>
                                    <option value="2">Driving License</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Upload Scan Copy of Proof <span>*</span></label>
                                <input type="file" class="form-control" name="id_proof_file" id="id_proof_file">
                                <a href="">View</a>
                            </div>
                            <div class="col-lg-12">
                                <input type="submit" class="btn btn-primary" id="submit">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Detail Popup -->
<div class="modal fade" id="seatAllotmentModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body m-0">
                <div class="detailes">
                    <button type="button" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                    <h3 id="seat_details_info"></h3>
                    <span id="seat_name" style="display: none;"></span>

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0" Id="bookingDetails">

                                    <tr>
                                        <td class="w-50">Seat Owner Name</td>
                                        <td id="owner" class="uppercase"></td>
                                    </tr>

                                    <tr>
                                        <td>Plan Purchsed</td>
                                        <td id="planName"></td>
                                    </tr>
                                    <tr>
                                        <td>Plan Price & Current Status</td>
                                        <td id="price"></td>
                                    </tr>
                                    <tr>
                                        <td>Plan Type</td>
                                        <td id="planTypeName"></td>
                                    </tr>
                                    <tr>
                                        <td>Plan Timings</td>
                                        <td id="planTiming"></td>
                                    </tr>
                                    <tr>
                                        <td>Join On</td>
                                        <td id="joinOn"></td>
                                    </tr>
                                    <tr>
                                        <td>Plan Starts On</td>
                                        <td id="startOn"></td>
                                    </tr>
                                    <tr>
                                        <td>Plan Ends On (Pending Days)</td>
                                        <td id="endOn"></td>
                                    </tr>
                                    <tr>
                                        <td>Id Proof Name & Received Status</td>
                                        <td id="proof"></td>
                                    </tr>
                                </table>
                            </div>
                            <input type="hidden" value="" id="user_id">
                            <a id="upgrade" class="btn btn-primary mt-2 ">Upgrade Plan Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="seatAllotmentModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div id="success-message" class="alert alert-success" style="display:none;"></div>
    <div id="error-message" class="alert alert-danger" style="display:none;"></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body m-0">
                <form id="upgradeForm">
                    <div class="detailes">
                        <button type="button" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                        <h3 id="seat_number_upgrades"></h3>
                        <div class="row g-4 mt-1">
                            <div class="col-lg-6">
                                <label for="">Select Plan <span>*</span></label>
                                <select id="update_plan_id" class="form-control" name="plan_id">
                                    <option value="">Select Plan</option>
                                    @foreach($plans as $key => $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>

                                    @endforeach

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Plan Type <span>*</span></label>
                                <select id="updated_plan_type_id" class="form-control" name="plan_type_id" @readonly(true)>

                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Plan Price <span>*</span></label>
                                <input id="updated_plan_price_id" class="form-control" name="plan_price_id" @readonly(true)>

                            </div>
                            <div class="col-lg-6">
                                <label for="">Plan Ends On <span>*</span></label>
                                <input type="date" class="form-control" placeholder="Plan Ends On" id="update_plan_end_date" value="" readonly>
                            </div>
                            <div class="col-lg-12">
                                <input type="hidden" class="form-control char-only" name="seat_no" value="" id="update_seat_no">
                                <input type="hidden" class="form-control char-only" name="user_id" value="" id="update_user_id">
                                <input type="submit" class="btn btn-primary" id="submit">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('library.script')
@endsection