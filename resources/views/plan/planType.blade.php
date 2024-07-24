@extends('layouts.admin') 
@section('content') 

<!-- Main content -->

<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- Genral Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                
                <form action="{{ isset($planType) ? route('planType.update', $planType->id) : route('planType.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($planType))
                        @method('PUT')
                    @endif
                    
                    <div class="row mt-3">
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label> Plan Type<sup class="text-danger">*</sup></label>
                                <select class="form-control @error('name') is-invalid @enderror" name="name">
                                    <option value="FULLDAY (7:00 AM	10:00 PM)" {{ old('name', isset($planType) ? $planType->name : '') == 'FULLDAY (7:00 AM	10:00 PM)' ? 'selected' : '' }}>FULLDAY (7:00 AM 10:00 PM)</option>
                                    <option value="FIRST HALF (7:00 AM 2:00 PM)" {{ old('name', isset($planType) ? $planType->name : '') == 'FIRST HALF (7:00 AM 2:00 PM)' ? 'selected' : '' }}>FIRST HALF (7:00 AM 2:00 PM) </option>
                                    <option value="SECOND HALF (2:00 PM 2:00 PM)" {{ old('name', isset($planType) ? $planType->name : '') == 'SECOND HALF (2:00 PM 2:00 PM)' ? 'selected' : '' }}>SECOND HALF (2:00 PM 2:00 PM) </option>
                                    <option value="Hourly Slot 1 (7:00 AM 11:00 AM)" {{ old('name', isset($planType) ? $planType->name : '') == 'Hourly Slot 1 (7:00 AM 11:00 AM)' ? 'selected' : '' }}>Hourly Slot 1 (7:00 AM 11:00 AM) </option>
                                    <option value="Hourly Slot 2 (11:00 AM 2:00 PM)" {{ old('name', isset($planType) ? $planType->name : '') == 'Hourly Slot 2 (11:00 AM 2:00 PM)' ? 'selected' : '' }}>Hourly Slot 2 (11:00 AM 2:00 PM) </option>
                                    <option value="Hourly Slot 3 (2:00 PM 6:00 PM)" {{ old('name', isset($planType) ? $planType->name : '') == 'Hourly Slot 3 (2:00 PM 6:00 PM)' ? 'selected' : '' }}>Hourly Slot 3 (2:00 PM 6:00 PM) </option>
                                    <option value="Hourly Slot 4 (6:00 PM 10:00 PM)" {{ old('name', isset($planType) ? $planType->name : '') == 'Hourly Slot 4 (6:00 PM 10:00 PM)' ? 'selected' : '' }}>Hourly Slot 4 (6:00 PM 10:00 PM)</option>
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
