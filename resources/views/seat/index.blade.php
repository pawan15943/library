@extends('layouts.admin') 
@section('content') 

<!-- Main content -->
<style>
    .seat-booking {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
        background: #fff;
        justify-content: space-between;
    }

    .seat-booking .seat_no {
        /* background: red; */
        height: 75px;
        width: 75px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        border: 1px solid #ddd;
    }

    .seat-booking .seat_no:hover {
        background-color: #f5f5f5;
    }

    .seat {
        position: relative;
        width: 57px;
    }

    .seat .number {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        font-size: 13px;
        top: 5px;
        z-index: 1;
    }

    h3 {
        font-weight: 700;
    }

    .d-flex.color_lable {
        justify-content: space-between;
        margin-top: 1rem;
    }



    .d-flex.color_lable div {
        display: flex;
        gap: .5rem;
        align-items: center;
    }

    .d-flex.color_lable span {
        display: block;
        width: 17px;
        height: 17px;
    }

    .d-flex.color_lable .full-day span {
        background: #5dc13a;
    }

    .d-flex.color_lable .first-half span {
        background: #ffa828;
    }

    .d-flex.color_lable .second-half span {
        background: #e2bb5e;
    }

    .d-flex.color_lable .available span {
        background: #d51b1b;
    }

    .d-flex.color_lable .not-available span {
        background: #C7C7C7;
    }

    .detailes {
        position: relative;
    }

    .detailes button {
        background: #bd4646;
        border: none;
        width: 40px;
        height: 40px;
        position: absolute;
        right: -16px;
        top: -16px;
        border-radius: 0 .43rem 0rem .5rem;
        font-size: 1rem !important;
        color: #fff !IMPORTANT;
        font-weight: 900;
    }

    .detailes button:hover {
        background: #ffa828;

    }

    label {
        display: inline-block;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: .3rem;
        color: #5d5d5d;
    }

    label span {
        color: red;
    }

    .form-control,
    .form-select {
        font-size: .9rem;
    }

    input.btn.btn-primary {
        background: green;
        border: none;
        border-radius: 2rem;
        padding: .5rem 1.5rem;
    }

    .seat.half {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .seat.half_day_wise img {
        width: 100%;
        padding: .2rem;
    }

    .seat.hourly_wise {
 
        display: flex;
        flex-wrap: wrap;
    }

    .seat.hour img {
        width: 50%;
        padding: .2rem;
    }
    .seat_no {
    display: flex;
    flex-wrap: wrap;
    }

    .seat_no .hourly_wise {
        width: 45%;
    }

    .seat_no .hourly_wise img {
        width: 30px;
    }
</style>

@php
    use App\Models\Customers;
@endphp
<div class="row justify-content-center">
    <div class="col-lg-10 p-5">
        <h3 class="text-center mb-4">Library Seat Allotment</h3>
        <div class="seat-booking">
            @foreach($seats as $seat)
                <div class="seat_no  ">
                    @php
                        $usersForSeat = Customers::where('seat_no', $seat->id)->select('id','seat_no','plan_type_id');
                        //available(not booked)=1,not available=0, firstHBook= 2 secondHbook=3 hourly=4 , fullbooked=5
                        //plan type 1=fullday, 2=firstH, 3=secondH,4=hourly	
                     
                    @endphp
                    
                    @if($usersForSeat->count() > 0)
                        @php
                            $usersForSeat=$usersForSeat->get();
                        @endphp
                        @foreach($usersForSeat as $user)
                          
                            @if($user->plan_type_id == 1)

                                <div class="seat second_popup" id="{{ $user->id }}">
                                    <div class="number">{{ $user->seat_no }}</div>
                                    <img src="{{ asset('public/img/full-day.svg') }}" alt="seat" class="seat_svg">
                                </div>
                            @elseif($user->plan_type_id == 2)
                                <div class="seat half_day_wise second_popup"  id="{{ $user->id }}">
                                    <div class="number">{{$user->seat_no }}</div>
                                    <img src="{{ asset('public/img/first-half.svg') }}" alt="seat" class="seat_svg">
                                </div> 
                            @elseif($user->plan_type_id == 3)
                                <div class="seat half_day_wise second_popup" id="{{ $user->id }}">
                                    <div class="number">{{$user->seat_no }}</div>
                                    <img src="{{ asset('public/img/second-half.svg') }}" alt="seat" class="seat_svg">
                                </div>
                            @elseif($user->plan_type_id == 4 || $user->plan_type_id == 5 || $user->plan_type_id == 6)
                                <div class="seat hourly_wise second_popup" id="{{ $seat->id }}">
                                    <div class="number">{{$user->seat_no }}</div>
                                    
                                    <img src="{{ asset('public/img/full-day.svg') }}" alt="seat" class="seat_svg"> 
                                </div>
                                
                            @endif
                          
                        @endforeach
                       
                        @php
                        // Calculate remaining hours for the seat to show unbooked seat if needed
                        //not given hourly image then add full_day
                        $totalBookedHours = $seat->total_hours;
                        $remainingHours = 16 - $totalBookedHours; 
                      
                        // Assuming a 16-hour booking window for the seat
                        @endphp
                         @if($remainingHours>0)
                         <div class="seat first_popup" id="{{ $seat->id }}">
                            <div class="number">{{ $seat->seat_no }}</div>
                            <img src="{{ asset('public/img/available.svg') }}" alt="seat" class="seat_svg">
                        </div>
                        @endif
                        

                    @else
                        
                        <div class="seat first_popup" id="{{ $seat->id }}">
                            <div class="number">{{ $seat->seat_no }}</div>
                            <img src="{{ asset('public/img/available.svg') }}" alt="seat" class="seat_svg">
                        </div>
                        
                    @endif
                </div>
            @endforeach
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
                <span></span> Available ({{$available}})
            </div>
            <div class="not-available">
                <span></span> Not Available ({{$not_available}})
            </div>
        </div>
       
    </div>
</div>

<!-- /.content -->
    <div class="modal fade" id="seatAllotmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="seatAllotmentForm">
                        <div class="detailes">
                            <div class="seat">
                                <div class="number"></div>
                                {{-- <img src="assets/images/first-half.svg" alt="first-half" class="seat"> --}}
                            </div>
                            <button type="button" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="las la-times"></i></button>
                            <input type="hidden" class="form-control char-only" name="seat_no" value="" id="seat_no">

                            <div class="row g-3 mt-1">
                                <div class="col-lg-12">
                                    <label for="">Full Name <span>*</span></label>
                                    <input type="text" class="form-control char-only" placeholder="Full Name" name="name" id="name">
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Mobile Number <span>*</span></label>
                                    <input type="text" class="form-control digit-only" placeholder="Mobile Number" name="mobile" id="mobile">
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Email Id <span>*</span></label>
                                    <input type="text" class="form-control" placeholder="Email Id" name="email" id="email">
                                </div>
                                <div class="col-lg-6">
                                    <label for="">DOB <span>*</span></label>
                                    <input type="date" class="form-control" placeholder="Plan Starts On" name="dob" id="dob">
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Select Plan <span>*</span></label>
                                    <select name="" id="plan_id" class="form-control"  name="plan_id" >
                                        <option value="">Select Plan</option>
                                        @foreach($plans as $key => $value)
                                        @if($value->name==7)
                                        <option value="{{$value->id}}">Yearly</option>
                                        @else
                                        <option value="{{$value->id}}">{{$value->name}}months</option>
                                        @endif
                                        
                                        @endforeach
                                    
                                        
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Plan Type <span>*</span></label>
                                    <select  id="plan_type_id" class="form-control" name="plan_type_id">
                                        <option value="">Select Plan Type</option>
                                        @foreach($plan_types as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Plan Starts On <span>*</span></label>
                                    <input type="date" class="form-control" placeholder="Plan Starts On" name="plan_start_date" id="plan_start_date">
                                </div>
                              
                                <div class="col-lg-6">
                                    <label for="">Plan Price <span>*</span></label>
                                    <select id="plan_price_id" class="form-control" name="plan_price_id">
                                        <option value="">Select Price</option>
                                        
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Payment Mode <span>*</span></label>
                                    <select name="payment_mode" id="payment_mode" class="form-control">
                                        <option value="">Select Payment Mode</option>
                                        <option value="1">Online</option>
                                        <option value="2">Offline</option>
                                        <option value="3">Pay Later</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
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
    <div class="modal fade" id="seatAllotmentModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body m-0">
                    <div class="detailes">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="seat">
                                    <div class="number" ></div>
                                    {{-- <img src="assets/images/first-half.svg" alt="first-half" class="seat"> --}}
                                </div>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close"><i
                                        class="las la-times"></i></button>
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered mb-0">
                                        <h3 id="seat_name" class="text-center"></h3>
                                        <tr>
                                            <th>Seat Owner Name</th>
                                            <th id="owner"></th>
                                        </tr>
                                        <tr>
                                            <td>Id Proof</td>
                                            <td id="proof"></td>
                                        </tr>
                                        <tr>
                                            <td>Selected Plan</td>
                                            <td id="planName"></td>
                                        </tr>
                                        <tr>
                                            <td>Plan Type</td>
                                            <td id="planTypeName"></td>
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
                                            <td>Plan Ends On</td>
                                            <td id="endOn"></td>
                                        </tr>
                                        <tr>
                                            <td>Plan Price</td>
                                            <td id="price"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden"  value="" id="user_id">
                                    <button id="upgrade">Upgrade</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="seatAllotmentModal3" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body m-0">
                    <form id="upgradeForm">
                        <div class="detailes">
                            <div class="seat">
                                <div class="number"></div>
                                {{-- <img src="assets/images/first-half.svg" alt="first-half" class="seat"> --}}
                            </div>
                            <button type="button" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="las la-times"></i></button>
                            

                            <div class="row g-3 mt-1">
                            
                                <div class="col-lg-6">
                                    <label for="">Select Plan <span>*</span></label>
                                    <select name="" id="update_plan_id" class="form-control"  name="plan_id" >
                                        <option value="">Select Plan</option>
                                        @foreach($plans as $key => $value)
                                        @if($value->name==7)
                                        <option value="{{$value->id}}">Yearly</option>
                                        @else
                                        <option value="{{$value->id}}">{{$value->name}}months</option>
                                        @endif
                                        
                                        @endforeach
                                    
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Plan Type <span>*</span></label>
                                    <select  id="updated_plan_type_id" class="form-control" name="plan_type_id">
                                        <option value="">Select Plan Type</option>
                                        @foreach($plan_types as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Plan Price <span>*</span></label>
                                    <select id="updated_plan_price_id" class="form-control" name="plan_price_id">
                                        <option value="">Select Price</option>
                                        
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Plan Ends On <span>*</span></label>
                                    <input type="date" class="form-control" placeholder="Plan Ends On"  id="update_plan_end_date" value="" readonly>
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
<script>
    // jQuery script
    $(document).ready(function () {
        $('.first_popup').on('click', function () {
            var seatId = $(this).attr('id');
            $('.detailes .number').text(seatId);
            $('#seatAllotmentModal').modal('show');
            $('#seat_no').val(seatId);
        });
        $('.second_popup').on('click', function () {
            var seatId = $(this).attr('id');
            $('.detailes .number').text(seatId);
            $('#seatAllotmentModal2').modal('show');
            $('#user_id').val(seatId);
            if (seatId) {
                $.ajax({
                    url: '{{ route('geUser') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": seatId,
                    },
                    dataType: 'json',
                    success: function (html) {
                       
                        $('#owner').text(html.name);
                        if(html.id_proof_name==1){
                            var proof='Aadhar';
                        }else if(html.id_proof_name==2){
                            var proof='Driving License';
                        }else{
                            var proof='Other';
                        }
                        if(html.plan_name==7){
                            var plan='yearly';
                        }else{
                            var plan=(html.plan_name)+' months';
                        }
                        $('#proof').text(proof); 
                        $('#planName').text(plan);
                        $('#planTypeName').text(html.plan_type_name);
                        $('#joinOn').text(html.join_date);
                        $('#startOn').text(html.plan_start_date); 
                        $('#endOn').text(html.plan_end_date);
                        $('#price').text(html.price);
                         $('#seat_name').text(html.seat_no);
                    }
                });
            }


        });
        $('#upgrade').on('click', function () {
            var user_id = $('#user_id').val();
            var seat_no = $('#seat_name').text().trim();
           
            var endOnDate = $('#endOn').text().trim();

            // Hide the first modal
            $('#seatAllotmentModal2').modal('hide');
          
            // Update the fields in the second modal
            $('#update_plan_end_date').val(endOnDate);
            $('#update_seat_no').val(seat_no);
            $('#update_user_id').val(user_id);

            // Show the second modal
            $('#seatAllotmentModal3').modal('show');
        });
        // $(document).on('change', '#plan_id', function(event) {
        
        //     event.preventDefault();

        //     var plan_id = $(this).val();
       

        //     if (plan_id) {
        //         $.ajax({
        //             url: '{{ route('gettypePlanwise') }}',
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //             },
        //             type: 'GET',
        //             data: {
        //                 "_token": "{{ csrf_token() }}",
        //                 "plan_id": plan_id,
        //             },
        //             dataType: 'json',
        //             success: function (html) {
                        
        //                 if (html) {
        //                     $("#plan_type_id").empty();
        //                     $("#plan_type_id").append('<option value="">Select Plan Type</option>');
        //                     $.each(html, function(key, value) {
        //                         $("#plan_type_id").append('<option value="'+key+'">'+value+'</option>');
        //                     });
        //                 } else {
        //                     $("#plan_type_id").append('<option value="">Select Plan Type</option>');
        //                 }
                        
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error("AJAX error:", status, error); // Log any errors
        //             }
        //             });
        //     } else {
        //             $("#plan_type_id").empty();
        //             $("#plan_type_id").append('<option value="">Select Plan Type</option>');
        //     }
        // });
        // $(document).on('change', '#update_plan_id', function(event) {
        
        //     event.preventDefault();

        //     var plan_id = $(this).val();
    

        //     if (plan_id) {
        //         $.ajax({
        //             url: '{{ route('gettypePlanwise') }}',
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //             },
        //             type: 'GET',
        //             data: {
        //                 "_token": "{{ csrf_token() }}",
        //                 "plan_id": plan_id,
        //             },
        //             dataType: 'json',
        //             success: function (html) {
                        
        //                 if (html) {
        //                     $("#updated_plan_type_id").empty();
        //                     $("#updated_plan_type_id").append('<option value="">Select Plan Type</option>');
        //                     $.each(html, function(key, value) {
        //                         $("#updated_plan_type_id").append('<option value="'+key+'">'+value+'</option>');
        //                     });
        //                 } else {
        //                     $("#updated_plan_type_id").append('<option value="">Select Plan Type</option>');
        //                 }
                        
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error("AJAX error:", status, error); // Log any errors
        //             }
        //             });
        //     } else {
        //             $("#updated_plan_type_id").empty();
        //             $("#updated_plan_type_id").append('<option value="">Select Plan Type</option>');
        //     }
        // });
        
        $('#plan_type_id').on('change', function(event) {
            event.preventDefault();
            var plan_type_id = $(this).val();

            if (plan_type_id) {
                $.ajax({
                    url: '{{ route('getPricePlanwise') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "plan_type_id": plan_type_id,
                    },
                    dataType: 'json',
                    success: function (html) {
                        if (html) {
                            $("#plan_price_id").empty();
                            $("#plan_price_id").append('<option value="">Select Plan Price</option>');
                            $.each(html, function(key, value) {
                                $("#plan_price_id").append('<option value="'+key+'">'+value+'</option>');
                            });
                        } else {
                            $("#plan_price_id").append('<option value="">Select Plan Price</option>');
                        }
                    }
                });
            } else {
                $("#plan_price_id").empty();
                $("#plan_price_id").append('<option value="">Select Plan Price</option>');
            }
        });
        $('#updated_plan_type_id').on('change', function(event) {
            event.preventDefault();
            var plan_type_id = $(this).val();

            if (plan_type_id) {
                $.ajax({
                    url: '{{ route('getPricePlanwise') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "plan_type_id": plan_type_id,
                    },
                    dataType: 'json',
                    success: function (html) {
                        if (html) {
                            $("#updated_plan_price_id").empty();
                            $("#updated_plan_price_id").append('<option value="">Select Plan Price</option>');
                            $.each(html, function(key, value) {
                                $("#updated_plan_price_id").append('<option value="'+key+'">'+value+'</option>');
                            });
                        } else {
                            $("#updated_plan_price_id").append('<option value="">Select Plan Price</option>');
                        }
                    }
                });
            } else {
                $("#updated_plan_price_id").empty();
                $("#updated_plan_price_id").append('<option value="">Select Plan Price</option>');
            }
        });

        $(document).on('submit', '#seatAllotmentForm', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    var seat_no = $('#seat_no').val();
    var name = $('#name').val();
    var mobile = $('#mobile').val();
    var email = $('#email').val();
    var dob = $('#dob').val();
    var plan_id = $('#plan_id').val();
    var plan_type_id = $('#plan_type_id').val();
    var plan_start_date = $('#plan_start_date').val();
    var id_proof_name = $('#id_proof_name').val();
    var id_proof_file = $("#id_proof_file")[0].files[0];
  
    if (!name) {
        Swal.fire({
            title: 'Error!',
            text: 'Full Name is required.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!mobile) {
        Swal.fire({
            title: 'Error!',
            text: 'Mobile number is required.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!email) {
        Swal.fire({
            title: 'Error!',
            text: 'Email Id is required.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!dob) {
        Swal.fire({
            title: 'Error!',
            text: 'Date of Birth is required.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!plan_id) {
        Swal.fire({
            title: 'Error!',
            text: 'Select Plan is required.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!plan_type_id) {
        Swal.fire({
            title: 'Error!',
            text: 'Select Plan Type is required.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!plan_start_date) {
        Swal.fire({
            title: 'Error!',
            text: 'Plan Start Date is required.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!id_proof_name) {
        Swal.fire({
            title: 'Error!',
            text: 'ID Proof is required.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (!id_proof_file) {
        Swal.fire({
            title: 'Error!',
            text: 'ID Proof file is required.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    formData.append('_token', '{{ csrf_token() }}');
    formData.append('plan_id', plan_id);
    formData.append('plan_type_id', plan_type_id);
    formData.append('id_proof_name', id_proof_name);

    $.ajax({
        url: '{{ route('customers.store') }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
                console.log(response);
            if (response.success) {
                console.log('Form submission successful, reloading page');
                window.location.href = '{{ route('seats') }}';
                location.reload(true); // Force reload from the server
                alert('call me');

            } else if (response.errors) {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                $.each(response.errors, function (key, value) {
                    var inputField = $("input[name='" + key + "'], select[name='" + key + "']");
                    inputField.addClass("is-invalid");
                    inputField.after('<div class="invalid-feedback">' + value + '</div>');
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX request failed');
            Swal.fire({
                title: 'Error!',
                text: 'Something went wrong. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});


        $(document).on('submit', '#seatAllotmentForm', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var seat_no = $('#seat_no').val();
            var name = $('#name').val();
            var mobile = $('#mobile').val();
            var email = $('#email').val();
            var dob = $('#dob').val();
            var plan_id = $('#plan_id').val();
            var plan_type_id = $('#plan_type_id').val();
            var plan_start_date = $('#plan_start_date').val();
            var plan_end_date = $('#plan_end_date').val();
            var id_proof_name = $('#id_proof_name').val();
            var id_proof_file = $("#id_proof_file")[0].files[0];
            console.log(plan_type_id);
            console.log(plan_id);
            if (!name) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Full Name is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!mobile) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Mobile number is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!email) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Email Id is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!dob) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Date of Birth is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!plan_id) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Select Plan is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!plan_type_id) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Select Plan Type is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!plan_start_date) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Plan Start Date is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

          

            
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('plan_id', plan_id);
            formData.append('plan_type_id', plan_type_id);
            formData.append('id_proof_name', id_proof_name);

            $.ajax({
                url: '{{ route('customers.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success'
                        }).then(function() {
                            location.reload();
                        });
                    } else if (response.errors) {
                        $(".is-invalid").removeClass("is-invalid");
                        $(".invalid-feedback").remove();

                        $.each(response.errors, function (key, value) {
                            $("input[name='" + key + "']").addClass("is-invalid");
                            $("input[name='" + key + "']").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });

        $(document).on('submit', '#upgradeForm', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var seat_no = $('#update_seat_no').val();
            var user_id = $('#update_user_id').val();
            var plan_id = $('#update_plan_id').val();
           
            var plan_type_id = $('#updated_plan_type_id').val();
            var plan_price_id = $('#updated_plan_price_id').val();
           
            if (!plan_id) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Select Plan is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!plan_type_id) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Select Plan Type is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!plan_price_id) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Select Price is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

           

            formData.append('_token', '{{ csrf_token() }}');
            formData.append('seat_no', seat_no);
            formData.append('user_id', user_id);
            formData.append('plan_id', plan_id);
            formData.append('plan_type_id', plan_type_id);
            formData.append('plan_price_id', plan_price_id);
           

            $.ajax({
                url: '{{ route('user.update') }}', // Update this URL to your route for updating seats
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success'
                        }).then(function() {
                            location.reload();
                        });
                    } else if (response.errors) {
                        $(".is-invalid").removeClass("is-invalid");
                        $(".invalid-feedback").remove();

                        $.each(response.errors, function(key, value) {
                            $("input[name='" + key + "']").addClass("is-invalid");
                            $("input[name='" + key + "']").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });

    });

</script>
@endsection
