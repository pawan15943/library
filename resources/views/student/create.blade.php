@extends('layouts.admin')

@section('content') 

<!-- Main content -->
<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- General Information -->
        <div class="card card-default" id="createStudent">
            <div class="card-body">
                
                <form action="{{ isset($student) ? route('student.update', $student->id) : route('student.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($student))
                        @method('PUT')
                    @endif
                    
                    <div class="row">
                       
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Full Name<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control char-only @error('name') is-invalid @enderror" name="name" 
                                    value="{{ old('name', isset($student) ? $student->name : '') }}" placeholder="Enter full name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mobile No.<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control digit-only @error('mobile') is-invalid @enderror" name="mobile" maxlength="10" minlength="10"
                                    value="{{ old('mobile', isset($student) ? $student->mobile : '') }}" placeholder="Enter mobile number">
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
                                <input type="text" class="form-control digit-only @error('alt_mobile') is-invalid @enderror" name="alt_mobile" maxlength="10" minlength="10"
                                    value="{{ old('alt_mobile', isset($student) ? $student->alt_mobile : '') }}" placeholder="Enter alternative mobile number">
                                @error('alt_mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Email Address<sup class="text-danger">*</sup></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" 
                                    value="{{ old('email', isset($student) ? $student->email : '') }}" placeholder="Enter email address">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Father's Name<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control char-only @error('father_name') is-invalid @enderror" name="father_name" 
                                    value="{{ old('father_name', isset($student) ? $student->father_name : '') }}" placeholder="Enter father's name">
                                @error('father_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>DOB<sup class="text-danger">*</sup></label>
                                <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" 
                                    value="{{ old('dob', isset($student) ? $student->dob : '') }}">
                                @error('dob')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                                <label>Gender<sup class="text-danger">*</sup></label>
                                <div class="d-flex">
                                <label for="male">
                                    <input type="radio" id="male" name="gender" value="male" @error('gender') is-invalid @enderror"
                                        {{ old('gender', isset($student) ? $student->gender : '') == 'male' ? 'checked' : '' }}>
                                    Male</label>
                                    <label for="female">
                                    <input type="radio" id="female" name="gender" value="female"  @error('gender') is-invalid @enderror"
                                        {{ old('gender', isset($student) ? $student->gender : '') == 'female' ? 'checked' : '' }}>
                                    Female</label><br>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Class<sup class="text-danger">*</sup></label>
                                <select name="grade_id" id="grade" class="form-control @error('grade_id') is-invalid @enderror event">
                                    <option value="">Select Class</option>
                                    @foreach($grades as $value)
                                    <option value="{{ $value->id }}" 
                                        {{ old('grade_id', isset($student) ? $student->grade_id : '') == $value->id ? 'selected' : '' }}>
                                        {{ $value->class_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('grade_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Stream<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control char-only @error('stream') is-invalid @enderror" name="stream" 
                                    value="{{ old('stream', isset($student) ? $student->stream : '') }}" placeholder="Enter stream">
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
                                        <option value="{{ $value->id }}" {{ old('state_id', isset($student) ? $student->state_id : '') == $value->id ? 'selected' : '' }}>
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
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Address">{{ old('address', isset($student) ? $student->address : '') }}</textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Pin Code<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control digit-only @error('pin_code') is-invalid @enderror" name="pin_code" 
                                    value="{{ old('pin_code', isset($student) ? $student->pin_code : '') }}" placeholder="Enter pin code" maxlength="6" minlength="6">
                                @error('pin_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Course Type<sup class="text-danger">*</sup></label>
                                <select name="course_type_id" id="course_type" class="form-control @error('course_type_id') is-invalid @enderror event">
                                    <option value="">Select Course Type</option>
                                    @foreach($course_types as $value)
                                        <option value="{{ $value->id }}" {{ old('course_type_id', isset($student) ? $student->course_type_id : '') == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Course<sup class="text-danger">*</sup></label>
                                <select name="course_id" id="course" class="form-control @error('course_id') is-invalid @enderror ">
                                    @if(isset($student) && $student->course_id )
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $key => $value)
                                        <option value="{{$value}}" @if($value == $student->course_id) {{ "selected" }} @endif>{{$key}}</option> 
                                        @endforeach
                                    @else
                                    <option value="">Select Course</option>

                                    @endif
                                </select>
                                @error('course_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Course Duration (in months)<sup class="text-danger">*</sup></label>
                                <input type="text" id="duration" class="form-control @error('duration') is-invalid @enderror"  value="{{ old('duration', isset($student) ? $fees->duration : '') }}" name="duration" readonly>
                                @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Course Fees<sup class="text-danger">*</sup></label>
                                <input type="text" id="fees" class="form-control @error('fees') is-invalid @enderror"  value="{{ old('fees', isset($student) ? $fees->course_fees : '') }}" readonly name="fees">
                                @error('fees')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Profile Image</label>
                                <input type="file" class="form-control @error('profile_image') is-invalid @enderror" name="profile_image" accept="image/*">
                                @error('profile_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        @if(isset($student) && $student->profile_image)
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Current Profile Image</label>
                                    <div>
                                        <img src="{{ asset('storage/' . $student->profile_image) }}" alt="Profile Image" class="img-thumbnail" width="150">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($student) ? 'Update' : 'Register' }}
                            </button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
@include('script')
@endsection

{{-- <script>
    /** Students modules Script***/
    $(document).ready(function() {
       
        var oldDuration = "{{ old('duration', isset($student) ? $fees->duration : '') }}";
        var oldFees = "{{ old('fees', isset($student) ? $fees->course_fees : '') }}";
        
        if (oldDuration) {
            $('#duration').val(oldDuration);
        }
        if (oldFees) {
            $('#fees').val(oldFees);
        }

        // Function to fetch and set course details
        function readonlyget(courseID) {
            if (courseID) {
                console.log('Fetching details for course ID:', courseID); // Debugging line
                $.ajax({
                    url: '{{ url('/getCourseDetails') }}/' + courseID,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Response data:', data); // Debugging line
                        if (data && data.duration && data.fees) {
                            $('#duration').val(data.duration);
                            $('#fees').val(data.fees);
                        } else {
                            console.error('Invalid data:', data); // Debugging line
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error); // Debugging line
                    }
                });
            }
        }

        // Get initial course details if a course is already selected
        var course_id = $('#course').val();
      
        if (course_id) {
            readonlyget(course_id);
        }

        // Handle change event on course dropdown
        $('#course').change(function() {
            var courseID = $(this).val();
            console.log('Selected course ID:', courseID); // Debugging line
            if (courseID) {
                readonlyget(courseID);
            } else {
                $('#duration').val('');
                $('#fees').val('');
            }
        });
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
                    success: function(html) {
                        if(html){
                            $("#cityid").empty();
                            $("#cityid").append('<option value="">Select City</option>');
                            $.each(html, function(key, value){
                                var selected = (key == "{{ old('city_id', isset($student) ? $student->city_id : '') }}") ? 'selected' : '';
                                $("#cityid").append('<option value="'+key+'" '+selected+'>'+value+'</option>');
                            });
                        }else{
                            $("#cityid").append('<option value="">Select City</option>');
                        }
                    }
                });
            } else {
                $("#cityid").empty();
                $("#cityid").append('<option value="">Select City</option>');
            }
        });

        // Handle course type and course dropdowns
        $('#course_type').on('change', function(event){
            event.preventDefault();
            var courseTypeID = $(this).val();
           
            if (courseTypeID) {
                $.ajax({
                    url: '{{ url('/getCourse') }}/' + courseTypeID,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#course').empty();
                        $('#course').append('<option value="">Select Course</option>');
                        $.each(data, function(key, value) {
                            var selected = (key == "{{ old('course_id', isset($student) ? $student->course_id : '') }}") ? 'selected' : '';
                            $('#course').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#course').empty();
                $('#course').append('<option value="">Select Course</option>');
            }
        });

        // Handle course dropdown change to get duration and fees
        

        // Set the initial value of cities and courses if editing
        var stateID = $('#stateid').val();
        var cityID = "{{ old('city_id', isset($student) ? $student->city_id : '') }}";
        if (stateID && cityID) {
            $.ajax({
                url: '{{ url('/getCity') }}/' + stateID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#cityid').empty();
                    $('#cityid').append('<option value="">Select City</option>');
                    $.each(data, function(key, value) {
                        var selected = (key == cityID) ? 'selected' : '';
                        $('#cityid').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                    });
                }
            });
        }

        var courseTypeID = $('#course_type').val();
        var courseID = "{{ old('course_id', isset($student) ? $student->course_id : '') }}";
        if (courseTypeID && courseID) {
            $.ajax({
                url: '{{ url('/getCourse') }}/' + courseTypeID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#course').empty();
                    $('#course').append('<option value="">Select Course</option>');
                    $.each(data, function(key, value) {
                        var selected = (key == courseID) ? 'selected' : '';
                        $('#course').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                    });
                }
            });
        }

        // Trigger the initial change events to load the data if editing
        if (stateID) {
            $('#stateid').trigger('change');
        }
        if (courseTypeID) {
            $('#course_type').trigger('change');
        }
    });
</script> --}}
