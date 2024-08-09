@extends('layouts.admin') 
@section('content') 

<!-- Main content -->

<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- Genral Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                
                <form action="{{  route('seats.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                  
                    <div class="row mt-3">
                       
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label> Total Seat No.<sup class="text-danger">*</sup></label>
                                <input type="text" name="total_seats" class="form-control @error('total_seats') is-invalid @enderror" id="" placeholder="Enter Seats No." >
                                @error('total_seats')
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
@include('library.script')
@endsection
