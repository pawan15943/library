@extends('layouts.admin') 
@section('content') 

<!-- Main content -->

<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- Genral Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                
                <form action="{{ isset($plan) ? route('plan.update', $plan->id) : route('plan.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($plan))
                        @method('PUT')
                    @endif
                    
                    <div class="row mt-3">
                       
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label> Plan Name<sup class="text-danger">*</sup></label>
                                {{-- <input type="text" name="plan_id" class="form-control digit-only @error('plan_id') is-invalid @enderror" id="" placeholder="Enter Only months" value="{{ old('plan_id', isset($plan) ? $plan->plan_id : '') }}"> --}}
                                <select class="form-control @error('plan_id') is-invalid @enderror" name="plan_id">
                                    <option value="1" {{ old('plan_id', isset($plan) ? $plan->plan_id : '') == 1 ? 'selected' : '' }}>1 MONTH</option>
                                    <option value="3" {{ old('plan_id', isset($plan) ? $plan->plan_id : '') == 3 ? 'selected' : '' }}>3 MONTHS</option>
                                    <option value="6" {{ old('plan_id', isset($plan) ? $plan->plan_id : '') == 6 ? 'selected' : '' }}>6 MONTHS</option>
                                    <option value="9" {{ old('plan_id', isset($plan) ? $plan->plan_id : '') == 9 ? 'selected' : '' }}>9 MONTHS</option>
                                    <option value="12" {{ old('plan_id', isset($plan) ? $plan->plan_id : '') == 9 ? 'selected' : '' }}>12 MONTHS</option>
                                </select>
                                @error('plan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>

                    </div>
                    
                </form>
            </div>
            <!-- /.card-body -->
        </div>

    </div>
</div>
   
<!-- /.content -->

@endsection
