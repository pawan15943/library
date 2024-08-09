@extends('layouts.admin')
@section('content')
@php
$current_route = Route::currentRouteName();
if($current_route=='close.customer'){
 $readonly='readonly';
}else{
    $readonly='';
}
@endphp

<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- Add City Fields -->
        <div class="card card-default">
            <!-- Add City Fields -->
            <div class="card-body">
                
                @if($current_route=='edit.user' || $current_route=='close.customer')
                <a href="{{ route('customers.list') }}" class="btn btn-primary button"><i class="fa fa-long-arrow-left"></i> Go Back</a>
                <form action="{{ route('cutomer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="details">
                        <div class="row g-4 mt-4">
                            <input id="edit_seat" type="hidden" name="seat_no" value="{{ old('seat_no', $customer->seat_no) }}">
                            <div class="col-lg-6">
                                <label for="">Full Name <span>*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror char-only" placeholder="Full Name" name="name" id="name" value="{{ old('name', $customer->name) }}" {{$readonly}}>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="">DOB <span>*</span></label>
                                <input type="date" class="form-control @error('dob') is-invalid @enderror" placeholder="DOB" name="dob" id="dob" value="{{ old('dob', $customer->dob) }}" {{$readonly}}>
                                @error('dob')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="">Mobile Number <span>*</span></label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror digit-only" maxlength="10" minlength="10" placeholder="Mobile Number" name="mobile" id="mobile" value="{{ old('mobile', $customer->mobile) }}" {{$readonly}}>
                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="">Email Id <span>*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Id" name="email" id="email" value="{{ old('email', $customer->email) }}" {{$readonly}}>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label for=""> Plan <span>*</span></label>
                                <select id="plan_id" class="form-control @error('plan_id') is-invalid @enderror" name="plan_id" {{$readonly}}>
                                    <option value="">Select Plan</option>
                                    @foreach($plans as $key => $value)
                                    <option value="{{ $value->id }}" {{ old('plan_id', $customer->plan_id) == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('plan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label for="">Plan Type <span>*</span></label>
                                <select id="plan_type_id" class="form-control @error('plan_type_id') is-invalid @enderror" name="plan_type_id" {{$readonly}}>
                                    <option value="">Select Plan Type</option>
                                    <option value="{{$customer->plan_type_id}}" selected>{{$customer->plan_type_name}}</option>

                                </select>
                                @error('plan_type_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label for="">Plan Price <span>*</span></label>
                                <input id="plan_price_id" class="form-control @error('plan_price_id') is-invalid @enderror" name="plan_price_id" value="{{ old('plan_price_id', $customer->plan_price_id) }}" readonly>
                                @error('plan_price_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label for="">Plan Starts On <span>*</span></label>
                                <input type="date" class="form-control @error('plan_start_date') is-invalid @enderror" placeholder="Plan Starts On" name="plan_start_date" id="plan_start_date" value="{{ old('plan_start_date', $customer->plan_start_date) }}" {{$readonly}}>
                                @error('plan_start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @if($current_route=='close.customer')
                            <div class="col-lg-4">
                                <label for="">Plan End On <span>*</span></label>
                                <input type="date" class="form-control @error('plan_end_date') is-invalid @enderror" placeholder="Plan Starts On" name="plan_end_date" id="plan_end_date" value="{{ old('plan_end_date', $customer->plan_end_date) }}" >
                                @error('plan_end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @endif
                            <div class="col-lg-4">
                                <label for="">Payment Mode <span>*</span></label>
                                <select name="payment_mode" id="payment_mode" class="form-control @error('payment_mode') is-invalid @enderror" {{$readonly}}>
                                    <option value="">Select Payment Mode</option>
                                    <option value="1" {{ old('payment_mode', $customer->payment_mode) == 1 ? 'selected' : '' }}>Online</option>
                                    <option value="2" {{ old('payment_mode', $customer->payment_mode) == 2 ? 'selected' : '' }}>Offline</option>
                                    <option value="3" {{ old('payment_mode', $customer->payment_mode) == 3 ? 'selected' : '' }}>Pay Later</option>
                                </select>
                                @error('payment_mode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label for="">Id Proof Received </label>
                                <select id="id_proof_name" class="form-control @error('id_proof_name') is-invalid @enderror" name="id_proof_name" {{$readonly}}>
                                    <option value="">Select Id Proof</option>
                                    <option value="1" {{ old('id_proof_name', $customer->id_proof_name) == 1 ? 'selected' : '' }}>Aadhar</option>
                                    <option value="2" {{ old('id_proof_name', $customer->id_proof_name) == 2 ? 'selected' : '' }}>Driving License</option>
                                    <option value="3" {{ old('id_proof_name', $customer->id_proof_name) == 3 ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('id_proof_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="">Upload Scan Copy of Proof </label>
                                <input type="file" class="form-control @error('id_proof_file') is-invalid @enderror" name="id_proof_file" id="id_proof_file" {{$readonly}}>
                                @error('id_proof_file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                @if($customer->id_proof_file)
                                <a href="{{ asset('storage/' . $customer->id_proof_file) }}" target="_blank">View</a>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                <input type="submit" class="btn btn-primary btn-block" id="submit" value="Update">
                            </div>
                        </div>

                    </div>
                </form>
                @else
             
                <a href="{{ route('customers.list') }}" class="btn btn-primary button"><i class="fa fa-long-arrow-left"></i> Go Back</a>
                <div class="table-reponsive mt-4 ">
                    <table class="table table-bordered mb-0" id="detailsTable">
                        <thead>
                            <tr>
                                <th  class="w-50">Field Name</th>
                                <th>Values</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Seat Number </td>
                                <td>{{ $customer->seat_no }}</td>
                            </tr>
                            <tr>
                                <td>Full Name</td>
                                <td class="uppercase">{{ $customer->name }}</td>
                            </tr>
                            <tr>
                                <td>Email Id</td>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <td>Mobile Number</td>
                                <td>{{ $customer->mobile }}</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td>{{ $customer->dob }}</td>
                            </tr>
                            <tr>
                                <td>User Id Proof</td>
                                <td>{{ $customer->id_proof_name }}</td>
                            </tr>
                            <tr>
                                <td>Join Date</td>
                                <td>{{ $customer->join_date }}</td>
                            </tr>
                            <tr>
                                <td>Plan Name</td>
                                <td>{{ $customer->plan_name }}</td>
                            </tr>
                            <tr>
                                <td>Plan Type</td>
                                <td>{{ $customer->plan_type_name }}</td>
                            </tr>
                            <tr>
                                <td>Plan Duration</td>
                                <td>{{ $customer->hours }}</td>
                            </tr>
                            <tr>
                                <td>Payment Status</td>
                                <td>@php if( $customer->payment_mode == 1) { echo 'Paid'; } else { echo 'Pending'; } @endphp </td>
                            </tr>
                            <tr>
                                <td>Current Seat Status</td>
                                <td>{{ $customer->status ? 'Active' : 'Inactive' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                @endif
            </div>
        </div>
    </div>
</div>

@include('library.script')
@endsection