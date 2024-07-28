@extends('layouts.admin')

@section('content') 

<!-- Main content -->
<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- General Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                
                <form action="{{ isset($student) ? route('student.update', $student->id) : route('student.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($student))
                        @method('PUT')
                    @endif
                    
                    <div class="row mt-3">
                       
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text"  class="form-control char-only @error('name') is-invalid @enderror" name="name"  value="{{ old('name', isset($student) ? $student->name : '') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mobile No.</label>
                                <input type="text"  class="form-control digit-only @error('mobile') is-invalid @enderror" name="mobile"  value="{{ old('mobile', isset($student) ? $student->mobile : '') }}">
                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Alternative Mobile No.</label>
                                <input type="text"  class="form-control digit-only @error('alt_mobile') is-invalid @enderror" name="alt_mobile"  value="{{ old('alt_mobile', isset($student) ? $student->alt_mobile : '') }}">
                                @error('alt_mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email"  class="form-control @error('email') is-invalid @enderror" name="email"  value="{{ old('email', isset($student) ? $student->email : '') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Father's Name</label>
                                <input type="text"  class="form-control char-only @error('father_name') is-invalid @enderror" name="father_name"  value="{{ old('father_name', isset($student) ? $student->father_name : '') }}">
                                @error('father_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>DOB</label>
                                <input type="date"  class="form-control @error('dob') is-invalid @enderror" name="dob"  value="{{ old('dob', isset($student) ? $student->dob : '') }}">
                                @error('dob')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Gender</label>
                                
                                <input type="radio" id="male" name="gender" value="male" class="form-control @error('gender') is-invalid @enderror"
                                {{ isset($student) && $student->gender == 'male' ? 'checked' : '' }}>
                            <label for="male">Male</label><br>
                            <input type="radio" id="female" name="gender" value="female" class="form-control @error('gender') is-invalid @enderror"
                                {{ isset($student) && $student->gender == 'female' ? 'checked' : '' }}>
                            <label for="female">Female</label><br>
                            @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            
                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Class<sup class="text-danger">*</sup></label>
                                <select name="grade_id" id="grade" class="form-control @error('grade_id') is-invalid @enderror event">
                                    <option value="">Select Class</option>
                                   
                                    @foreach($grades as $value)
                                        <option value="{{ $value->id }}" {{  old('grade_id', isset($student) && $student->grade_id == $value->id ? 'selected' : '') }}>
                                            {{ $value->class_name }}
                                        </option>
                                    @endforeach
                                    @error('grade_id')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Stream</label>
                                <input type="text"  class="form-control char-only @error('stream') is-invalid @enderror" name="stream"  value="{{ old('stream', isset($student) ? $student->stream : '') }}">
                                @error('stream')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>State<sup class="text-danger">*</sup></label>
                                <select name="state_id" id="stateid" class="form-control @error('state_id') is-invalid @enderror event">
                                    <option value="">Select State</option>
                                    @foreach($states as $value)
                                        <option value="{{ $value->id }}" {{ isset($student) && $student->state_id == $value->id ? 'selected' : '' }}>
                                            {{ $value->state_name }}
                                        </option>
                                    @endforeach
                                    @error('state_id')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>City<sup class="text-danger">*</sup></label>
                                <select name="city_id" id="cityid" class="form-control @error('city_id') is-invalid @enderror event">
                                    @if(isset($student) && $student->city_id )
                                        @foreach ($cities as $key => $value)
                                        <option value="{{$value}}" @if($value == $student->city_id) {{ "selected" }} @endif>{{$key}}</option> 
                                        @endforeach
                                    @else
                                    <option value="">Select City</option>

                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Address<sup class="text-danger">*</sup></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address">{{ old('address', isset($student) ? $student->address : '') }}</textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Pin Code</label>
                                <input type="text"  class="form-control digit-only @error('pin_code') is-invalid @enderror" name="pin_code"  value="{{ old('pin_code', isset($student) ? $student->pin_code : '') }}">
                                @error('pin_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Course Type<sup class="text-danger">*</sup></label>
                                <select name="course_type_id" id="course_type" class="form-control @error('course_type_id') is-invalid @enderror event">
                                    <option value="">Select Course Type</option>
                                    @foreach($course_types as $value)
                                        <option value="{{ $value->id }}" {{ isset($student) && $student->course_type_id == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                    @error('course_type_id')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Course<sup class="text-danger">*</sup></label>
                                <select name="course_id" id="course" class="form-control @error('course_id') is-invalid @enderror ">
                                    @if(isset($student) && $student->course_id )
                                        @foreach ($courses as $key => $value)
                                        <option value="{{$value}}" @if($value == $student->course_id) {{ "selected" }} @endif>{{$key}}</option> 
                                        @endforeach
                                    @else
                                    <option value="">Select Course</option>

                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Duration (in months)</label>
                                <input type="text" id="duration" class="form-control @error('duration') is-invalid @enderror"  value="{{ old('duration', isset($student) ? $fees->duration : '') }}" readonly>
                                @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Fees</label>
                                <input type="text" id="fees" class="form-control @error('fees') is-invalid @enderror"  value="{{ old('fees', isset($student) ? $fees->course_fees : '') }}" readonly>
                                @error('fees')
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
                                {{ isset($student) ? 'Update' : 'Add' }}
                            </button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        // Handle state and city dropdowns
        $('#stateid').on('change', function(event){
               event.preventDefault();
               var state_id = $(this).val();
               console.log(state_id);
               if(state_id){
                   $.ajax({
                           url: '{{ route('cityGetStateWise') }}',
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                           },
                           type: 'GET',
                           data: {
                               "_token": "{{ csrf_token() }}",
                               "state_id": state_id,
                           
                           },

                           dataType: 'json',
                           success: function (html) {
                               
                               if(html){
                                   $("#cityid").empty();
                                   $("#cityid").append('<option value="">Select City</option>');
                                   $.each(html,function(key,value){
                                   
                                       $("#cityid").append('<option value="'+key+'">'+value+'</option>');
                                   });
                               }else{
                                   
                                   $("#cityid").append('<option value="">Select City</option>');
                               }
                               
                                   
                           }
                       });
               }else{
                   $("#cityid").empty();
                   $("#cityid").append('<option value="">Select City</option>');
               }
        });


        // Handle course type and course dropdowns
        $('#course_type').on('change', function(event){
            event.preventDefault();
      
            var courseTypeID = $(this).val();
            console.log(courseTypeID); 
            if (courseTypeID) {
                $.ajax({
                   
                    url: '{{ url('/getCourse') }}/' + courseTypeID,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#course').empty();
                        $('#course').append('<option value="">Select Course</option>');
                        $.each(data, function(key, value) {
                            $('#course').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#course').empty();
                $('#course').append('<option value="">Select Course</option>');
            }
        });

        // Handle course dropdown change to get duration and fees
        $('#course').change(function() {
            var courseID = $(this).val();
            if (courseID) {
                $.ajax({
                     url: '{{ url('/getCourseDetails') }}/' + courseID,
                  
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#duration').val(data.duration);
                        $('#fees').val(data.fees);
                    }
                });
            } else {
                $('#duration').val('');
                $('#fees').val('');
            }
        });

        // Set the initial value of cities and courses if editing
        var stateID = $('#stateid').val();
        var cityID = "{{ isset($student) ? $student->city_id : '' }}";
        if (stateID && cityID) {
            $.ajax({
                url: '/getCity/' + stateID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#cityid').empty();
                    $('#cityid').append('<option value="">Select City</option>');
                    $.each(data, function(key, value) {
                        $('#cityid').append('<option value="' + key + '"' + (key == cityID ? ' selected' : '') + '>' + value + '</option>');
                    });
                }
            });
        }

        var courseTypeID = $('#course_type').val();
        var courseID = "{{ isset($student) ? $student->course_id : '' }}";
        if (courseTypeID && courseID) {
            $.ajax({
                url: '/getCourse/' + courseTypeID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#course').empty();
                    $('#course').append('<option value="">Select Course</option>');
                    $.each(data, function(key, value) {
                        $('#course').append('<option value="' + key + '"' + (key == courseID ? ' selected' : '') + '>' + value + '</option>');
                    });
                }
            });
        }
    });
</script>
@endsection
