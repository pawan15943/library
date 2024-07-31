@extends('layouts.admin')

@section('content') 

<!-- Main content -->
<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- General Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                
                <form action="{{  route('admin.account.save_payment') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    
                    <div class="row mt-3">
                       
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Total Fees</label>
                                <input type="text" class="form-control @error('total_amount') is-invalid @enderror" name="total_amount" 
                                    value="{{ old('total_amount', isset($student) ? $total_fees : '') }}" readonly>
                                @error('total_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Pending Amount</label>
                                <input type="text" class="form-control @error('pending_amount') is-invalid @enderror" name="pending_amount" 
                                    value="{{ old('pending_amount', isset($student) ? $pending_amount : '') }}" readonly>
                                @error('pending_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Paid Amount</label>
                                <input type="text" class="form-control digit-only @error('paid_amount') is-invalid @enderror" name="paid_amount" 
                                    value="{{ old('paid_amount')}}" placeholder="Enter Amount">
                                @error('paid_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Paid Date</label>
                                <input type="date" class="form-control digit-only @error('paid_date') is-invalid @enderror" name="paid_date" 
                                    value="{{ old('paid_date')}}" >
                                @error('paid_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                     
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                               Submit
                            </button>
                        </div>
                    </div>
                </form>
                
            </div>
            <div class="card card-default">
                @php
                    $i = 1;
                @endphp
                @foreach($transaction_list as $key => $value)
                    <div class="transaction-item">
                        <label>Installment {{$i}}</label>
                        <div class="form-group">
                            <label>Paid Amount</label>
                            <input type="text" class="form-control" value="{{$value->paid_amount}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Pending Amount</label>
                            <input type="text" class="form-control" value="{{$value->pending_amount}}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Paid Amount Date</label>
                            <input type="text" class="form-control" value="{{$value->paid_date}}" readonly>
                        </div>
                    </div>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </div>
            
        </div>
    </div>
</div>



@endsection
