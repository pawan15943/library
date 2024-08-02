@extends('layouts.admin')
@section('content')
@php
    $current_route = Route::currentRouteName();
@endphp
<div class="container">
    
    @if($current_route=='edit.user')
      
        <a href="{{route('customers.list')}}" class="btn btn-primary mb-3">Back to Customers</a>
       
        <form action="{{ route('cutomer.update', $customer->id) }}" method="POST" enctype="multipart/form-data" id="seatAllotmentForm">
            @csrf
            @method('PUT')
            
            <div class="details">
                <div class="row g-3 mt-1">
                    <input type="hidden" name="seat_no" value="{{ old('seat_no', $customer->seat_no) }}">
                    <div class="col-lg-6">
                        <label for="">Full Name <span>*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror char-only" placeholder="Full Name" name="name" id="name" value="{{ old('name', $customer->name) }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="">DOB <span>*</span></label>
                        <input type="date" class="form-control @error('dob') is-invalid @enderror" placeholder="DOB" name="dob" id="dob" value="{{ old('dob', $customer->dob) }}">
                        @error('dob')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="">Mobile Number <span>*</span></label>
                        <input type="text" class="form-control @error('mobile') is-invalid @enderror digit-only" maxlength="10" minlength="10" placeholder="Mobile Number" name="mobile" id="mobile" value="{{ old('mobile', $customer->mobile) }}">
                        @error('mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="">Email Id <span>*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Id" name="email" id="email" value="{{ old('email', $customer->email) }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="">Select Plan <span>*</span></label>
                        <select id="plan_id" class="form-control @error('plan_id') is-invalid @enderror" name="plan_id">
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
                        <select id="plan_type_id" class="form-control @error('plan_type_id') is-invalid @enderror" name="plan_type_id">
                            <option value="">Select Plan Type</option>
                            @foreach($planTypes as $key => $value)
                                <option value="{{ $value->id }}" {{ old('plan_type_id', $customer->plan_type_id) == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                            @endforeach
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
                        <input type="date" class="form-control @error('plan_start_date') is-invalid @enderror" placeholder="Plan Starts On" name="plan_start_date" id="plan_start_date" value="{{ old('plan_start_date', $customer->plan_start_date) }}">
                        @error('plan_start_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label for="">Payment Mode <span>*</span></label>
                        <select name="payment_mode" id="payment_mode" class="form-control @error('payment_mode') is-invalid @enderror">
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
                        <label for="">Id Proof Received <span>*</span></label>
                        <select id="id_proof_name" class="form-control @error('id_proof_name') is-invalid @enderror" name="id_proof_name">
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
                        <label for="">Upload Scan Copy of Proof <span>*</span></label>
                        <input type="file" class="form-control @error('id_proof_file') is-invalid @enderror" name="id_proof_file" id="id_proof_file">
                        @error('id_proof_file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @if($customer->id_proof_file)
                            <a href="{{ asset('storage/' . $customer->id_proof_file) }}" target="_blank">View</a>
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-primary" id="submit" value="Update">
                    </div>
                </div>
                
            </div>
        </form>
        
    @else
    <h1>Customer Details</h1>
    <a href="{{ route('customers.list') }}" class="btn btn-primary mb-3">Back to Customers</a>
    
    <div class="card">
        <div class="card-header">
            <h2>{{ $customer->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Mobile:</strong> {{ $customer->mobile }}</p>
            <p><strong>Date of Birth:</strong> {{ $customer->dob }}</p>
            <p><strong>ID Proof:</strong> {{ $customer->id_proof_name }}</p>
            @if($customer->id_proof_file)
                <p><strong>ID Proof File:</strong> <a href="{{ asset('storage/' . $customer->id_proof_file) }}" target="_blank">View File</a></p>
            @endif
            <p><strong>Join Date:</strong> {{ $customer->join_date }}</p>
            <p><strong>Plan Start Date:</strong> {{ $customer->plan_start_date }}</p>
            <p><strong>Plan End Date:</strong> {{ $customer->plan_end_date }}</p>
            <p><strong>Plan Name:</strong> {{ $customer->plan_name }}</p>
            <p><strong>Plan Type:</strong> {{ $customer->plan_type_name }}</p>
            <p><strong>Seat No:</strong> {{ $customer->seat_no }}</p>
            <p><strong>Hours:</strong> {{ $customer->hours }}</p>
            <p><strong>Payment Mode:</strong> {{ $customer->payment_mode }}</p>
            <p><strong>Status:</strong> {{ $customer->status ? 'Active' : 'Inactive' }}</p>
        </div>
    </div>
    @endif
</div>
@endsection
