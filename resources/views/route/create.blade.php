@extends('layouts.admin') 
@section('content') 

<!-- Main content -->


<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- Genral Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                
                <form action="{{ isset($route) ? route('route.update', $route->id) : route('route.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($route))
                        @method('PUT')
                    @endif
                    
                    <div class="row mt-3">
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label> Center<sup class="text-danger">*</sup></label>
                                <select name="center_id" id="center_id" class="form-control @error('center_id') is-invalid @enderror event">
                                    <option value="">Select Center</option>
                                    @foreach ($arr_center as $center)
                                        <option value="{{ $center->id }}"
                                            {{ isset($route) && $route->center_id == $center->id ? 'selected' : '' }}>
                                            {{ $center->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                @error('center_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label> Route Name<sup class="text-danger">*</sup></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="" placeholder="Enter route name" value="{{ old('name', isset($route) ? $route->name : '') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Area (Local Area)<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control @error('areas') is-invalid @enderror"placeholder="Enter area name" id="" name="areas" value="{{ old('areas', isset($route) ? $route->areas : '') }}">
                                @error('areas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Distance (in KM)<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control @error('distance') is-invalid @enderror" placeholder="Enter distance in KM" id="" name="distance" value="{{ old('distance', isset($route) ? $route->distance : '') }}">
                                @error('distance')
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
