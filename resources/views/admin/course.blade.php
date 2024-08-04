@extends('layouts.admin')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- Add City Fields -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                <form id="submit">
                    @csrf

                    <div class="row g-4">
                        <input type="hidden" name="id" value="" id="course_id">
                        <div class="col-lg-3">
                            <label for="class_name"> Course Type<sup class="text-danger">*</sup></label>
                            <select id="course_type" name="course_type" class="form-control @error('course_type') is-invalid @enderror" placeholder="Select Course Type">
                                @error('course_type')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <option value="">Select Course Type</option>
                                @foreach ($course_type as $key => $value)
                                <option value="{{$value}}">{{$key}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="class_name"> Course Name<sup class="text-danger">*</sup></label>
                            <input type="text" id="course_name" name="course_name" value="{{ old('course_name') }}" class="form-control @error('course_name') is-invalid @enderror" placeholder="Enter Course Name">
                            @error('course_name')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="col-lg-3">
                            <label for="class_name"> Course Fees<sup class="text-danger">*</sup></label>
                            <input type="text" id="course_fees" name="course_fees" value="{{ old('course_fees') }}" class="form-control digit-only @error('course_fees') is-invalid @enderror" placeholder="Course Fees">
                        </div>

                        <div class="col-lg-3">
                            <label for="class_name"> Course Duration<sup class="text-danger">*</sup></label>
                            <input type="text" id="duration" name="duration" value="{{ old('duration') }}" class="form-control @error('duration') is-invalid @enderror" placeholder="Duration">
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
        <!-- Add City Fields -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body p-0">
                <h4 class="px-3 py-2">All Courses List</h4>
                <div class="table-responsive tableRemove_scroll mt-2">
                    <table class="table table-hover dataTable m-0" id="datatable" style="display:table !important">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Course Name</th>
                                <th>Course Fees </th>
                                <th>Duration</th>
                                <th>Course Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $x=1;
                            @endphp
                            @foreach($courses as $key => $course)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$course->course_name}}</td>

                                <td>{{$course->course_fees}}</td>

                                <td>{{$course->duration}} MONTHS</td>
                                <td>
                                    @if($course->is_active==1)
                                    <div class="text-success">Active</div>
                                    @else
                                    <div class="text-danger">Inactive</div>
                                    @endif
                                </td>

                                <td>
                                    <ul class="actionables">
                                        <li><a href="javascript:void(0)" type="button" class="course_edit" data-id="{{$course->id}}"><i class="fa fa-edit"></i></a></li>
                                        <li> <a href="javascript:void(0)" type="button" class="delete" data-id="{{$course->id}}"><i class="fa fa-trash"></i></a></li>
                                    </ul>



                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    $(document.body).on('submit', '#submit', function(event) {

        event.preventDefault();

        var formData = new FormData(this);
        var course_name = $('#course_name').val();
        var course_fees = $('#course_fees').val();
        var duration = $('#duration').val();
        var course_id = $('#course_id').val();



        if (course_name == '' || course_name == undefined) {
            Swal.fire({
                title: 'Error!',
                text: 'Course Name is required.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        if (course_fees == '' || course_fees == undefined) {
            Swal.fire({
                title: 'Error!',
                text: 'Course Fees is required.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }


        if (duration == '' || duration == undefined) {
            Swal.fire({
                title: 'Error!',
                text: 'Duration is required.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route('course.store') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            dataType: 'json',
            success: function(response) {

                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                } else if (response.errors) {

                    $(".is-invalid").removeClass("is-invalid");
                    $(".invalid-feedback").remove();

                    $.each(response.errors, function(key, value) {

                        $("input[name='" + key + "']").addClass("is-invalid");
                        $("input[name='" + key + "']").after('<span class="invalid-feedback" role="alert">' + value + '</span>');

                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }

            }
        });
    });

    $(document.body).on('click', '.course_edit', function() {
        var course_id = $(this).data('id');
        $.ajax({
            url: '{{ route('course.edit') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'GET',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": course_id,

            },

            dataType: 'json',
            success: function(response) {

                $('#course_name').val(response.course.course_name);

                $('#course_fees').val(response.course.course_fees);
                $('#course_type').val(response.course.course_type);

                $('#duration').val(response.course.duration);

                $('#course_id').val(response.course.id);

            }
        });

    });

    $('.delete').click(function(e) {
        if (!confirm('Are you sure you want to delete this Course?')) {
            e.preventDefault();
        }
        var course_id = $(this).data('id');
        $.ajax({
            url: '{{ route('course.destroy') }}',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": course_id,

            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    }).then(function() {

                        location.reload();

                    });
                } else {
                    // Handle other cases if needed
                }
            },
            error: function(error) {
                // Handle errors if the AJAX request fails
            }
        });

    });
</script>

@endsection