@extends('layouts.admin')

@section('content')

<!-- Main content -->
<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- General Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">

                <form action="{{  route('admin.account.save_payment') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <div class="row mt-3">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Total Fees</label>
                                <input type="text" class="form-control @error('total_amount') is-invalid @enderror" name="total_amount" value="{{ old('total_amount', isset($student) ? $total_fees : '') }}" readonly>
                                @error('total_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Pending Amount</label>
                                <input type="text" class="form-control @error('pending_amount') is-invalid @enderror" name="pending_amount" value="{{ old('pending_amount', isset($student) ? $pending_amount : '') }}" readonly>
                                @error('pending_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Paid Amount</label>
                                <input type="text" class="form-control digit-only @error('paid_amount') is-invalid @enderror" name="paid_amount" value="{{ old('paid_amount')}}" placeholder="Enter Amount">
                                @error('paid_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Paid Date</label>
                                <input type="date" class="form-control digit-only @error('paid_date') is-invalid @enderror" name="paid_date" value="{{ old('paid_date')}}">
                                @error('paid_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>

           
                @php
                $i = 1;
                @endphp

                <div class="transaction-item mt-4">
                    <!-- Payment Lists -->
                     <h4 class="py-3">Payment History :</h4>
                    <div class="table-responsive">
                        <table class="table table-hover m-0  ">
                            <thead>
                                <tr>
                                    <th>Installment No</th>
                                    <th>Paid Amt</th>
                                    <th>Pending Amt</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            @foreach($transaction_list as $key => $value)
                            <tbody>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$value->paid_amount}}</td>
                                    <td>{{$value->pending_amount}}</td>
                                    <td>{{$value->paid_date}}</td>
                                </tr>
                            </tbody>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                        </table>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>



@endsection