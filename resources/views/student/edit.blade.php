@extends('layouts.admin')
@section('content')

<!-- Main content -->

<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- Genral Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">

                <form action="{{ isset($subscri_id) ? route('student.update', $subscri_id->id) : route('student.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($subscri_id))
                    @method('PUT')
                    @endif

                    <input type="hidden" name="student_id" value="{{$student->id }}">
                    <!-- =======Personal Detail======== -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class=" pb-3">Personal Detail</h6>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Form No.<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control @error('form_num') is-invalid @enderror" id="" name="form_num" value="{{  $student->form_num }}" readonly>

                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Students Name<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="" value="{{ $student->name }}" readonly>

                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Students Name<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="" value="{{ $student->name }}" readonly>

                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Profile Email<sup class="text-danger">*</sup></label>
                                <input type="email" class="form-control @error('student_email') is-invalid @enderror" value="{{ $student->email }}" readonly>
                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Profile Mobile Number<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control  @error('student_mobile') is-invalid @enderror " value="{{ $student->mobile_no}}" readonly>

                            </div>
                        </div>


                    </div>
                    <!-- Enroll detail -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <h6 class=" pb-3">Enrollment Detail</h6>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country<sup class="text-danger">*</sup></label>
                                <input type="text" value="{{$student->countries_name}}" class="form-control" readonly>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>City<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control " value="{{ isset($student->other_city) && $student->other_city != "" ? $student->other_city : ($student->cities ?? "NA") }}" readonly>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Center<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control " value="{{$student->study_centers}}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Class<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control " value="{{ $student->classes}}" readonly>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Stream<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control " value="{{ isset($student->coursecategories) && $student->coursecategories != "" ? $student->coursecategories : "NA" }}" readonly>
                            </div>
                        </div>

                    </div>

                    <!--###### Addres details #####-->
                    {{-- <div class="row mt-3">
                                    <div class="col-12">
                                        <h6 class=" pb-3">Address Details</h6>
                                    </div>
                                    <div class="w-100"></div>

                                    <div class="col-lg-6 ">
                                        <div class="form-group">
                                            <label>Address1<sup class="text-danger">*</sup></label>
                                            <input type="text"
                                                class="form-control @error('address1') is-invalid @enderror"
                                                placeholder="Address1" id="" name="address1"
                                                value="{{ old('address1', $student->address1) }}">
                    @error('address1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>
        </div>

        <div class="col-lg-6 ">
            <div class="form-group">
                <label>Address2<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('address2') is-invalid @enderror" placeholder="Address2" id="" name="address2" value="{{ old('address2', $student->address2) }}">
                @error('address2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>



        <div class="col-lg-6 ">
            <div class="form-group">
                <label>Area<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('area') is-invalid @enderror" placeholder="Area" id="" name="area" value="{{ old('area', $student->area) }}">
                @error('area')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="col-lg-6 ">
            <div class="form-group">
                <label>Postal/Zip code<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control @error('zip_code') is-invalid @enderror " placeholder="Enter Postal/Zip code" id="" name="zip_code" value="{{ old('zip_code', $student->zip_code) }}">

                @error('zip_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
        </div>

        <div class="border-top w-100 pb-3 mt-3"></div>
        <div class="col-lg-12">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </div>
    </div> --}}
    <div class="row mt-3">
        <div class="col-12">
            <h6 class=" pb-3">Transportation Details</h6>
        </div>

        <div class="col-lg-6 ">
            <div class="form-group">
                <label>Select Route<sup class="text-danger">*</sup></label>
                <select name="route_id" id="route_id" class="form-control @error('route_id') is-invalid @enderror event">
                    <option value="">Select Route</option>
                    @foreach ($routes as $route)

                    <option value="{{ $route->id }}" {{ isset($subscri_id) && $subscri_id->route_id == $route->id ? 'selected' : '' }}>
                        {{ $route->name }}
                    </option>
                    @endforeach
                </select>

                @error('route_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="col-lg-6 ">
            <div class="form-group">

                <label>Landmark<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control char-only @error('landmark') is-invalid @enderror" placeholder="Enter Landmark" id="" name="landmark" value="{{ old('landmark', isset($subscri_id) ? $subscri_id->landmark : '') }}">
                @error('landmark')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="col-lg-6 ">
            <div class="form-group">
                <label>Amount(per month)<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control digit-only  @error('amount') is-invalid @enderror" placeholder="Enter Amount" id="" name="amount" value="{{ old('amount', isset($subscri_id) ? $subscri_id->amount : '') }}">
                @error('amount')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="col-lg-6 ">
            <div class="form-group">
                <label>Remark</label>
                <textarea placeholder="Enter your remark" class="form-control @error('remark') is-invalid @enderror" name="remark">{{ old('remark', isset($subscri_id) ? $subscri_id->remark : '') }}</textarea>

                @error('remark')
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

</section>
<!-- /.content -->


@endsection
