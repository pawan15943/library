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
                                <select class="form-control @error('name') is-invalid @enderror" name="name">
                                    <option value="1" {{ old('name', isset($plan) ? $plan->name : '') == 1 ? 'selected' : '' }}>1 month</option>
                                    <option value="2" {{ old('name', isset($plan) ? $plan->name : '') == 2 ? 'selected' : '' }}>2 months</option>
                                    <option value="3" {{ old('name', isset($plan) ? $plan->name : '') == 3 ? 'selected' : '' }}>3 months</option>
                                    <option value="4" {{ old('name', isset($plan) ? $plan->name : '') == 4 ? 'selected' : '' }}>4 months</option>
                                    <option value="5" {{ old('name', isset($plan) ? $plan->name : '') == 5 ? 'selected' : '' }}>5 months</option>
                                    <option value="6" {{ old('name', isset($plan) ? $plan->name : '') == 6 ? 'selected' : '' }}>6 months</option>
                                    <option value="7" {{ old('name', isset($plan) ? $plan->name : '') == 7 ? 'selected' : '' }}>Yearly</option>
                                </select>
                                @error('name')
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
