<script>
    /** Students modules Script***/
    $(document).ready(function() {

          // Handle state and city dropdowns
        $('#stateid').on('change', function(event){
            event.preventDefault();
            var state_id = $(this).val();
           
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
                        $('#duration').val('');
                        $('#fees').val('');
                        $('#course').append('<option value="">Select Course</option>');
                        $.each(data, function(key, value) {
                            // var selected = (key == "{{ old('course_id', isset($student) ? $student->course_id : '') }}") ? 'selected' : '';
                            $('#course').append('<option value="' + key + '" >' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#course').empty();
                $('#duration').val('');
                $('#fees').val('');
                $('#course').append('<option value="">Select Course</option>');
            }
        });
       // Handle change event on course dropdown
        $('#course').change(function() {
            var courseID = $(this).val();
            
            if (courseID) {
                readonlyget(courseID);
            } else {
                $('#duration').val('');
                $('#fees').val('');
            }
        });
       

        // Function to fetch and set course details
        function readonlyget(courseID) {
          
            if (courseID) {
               
                $.ajax({
                    url: '{{ url('/getCourseDetails') }}/' + courseID,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                       
                        if (data && data.duration && data.fees) {
                            $('#duration').val(data.duration);
                            $('#fees').val(data.fees);
                        } else {
                           
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
        // Set the initial value of cities and courses if editing
        var stateID = $('#stateid').val();
        var cityID = "{{ old('city_id', isset($student) ? $student->city_id : '') }}";
        console.log(stateID);
        console.log(cityID);
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

        $(document).on('click', '.toggle-active', function() {
         
            var id = $(this).data('id');
            var url = '{{ route('students.toggleActive', ':id') }}'; // Use placeholder for ID
            url = url.replace(':id', id); // Replace placeholder with actual ID
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change the active status of this student?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085D6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url , // Correct URL
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Updated!',
                                'Student active status has been updated.',
                                'success'
                            ).then(() => {
                                location.reload(); // Optionally, you can refresh the page
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while updating the status.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
        // Toggle Certificate Status
        $(document).on('click', '.toggle-certificate', function() {
            var id = $(this).data('id');
            var url = '{{ route('students.toggleCertificate', ':id') }}'; // Use placeholder for ID
            url = url.replace(':id', id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change the certificate status of this student?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085D6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:url, // Correct URL
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Updated!',
                                'Student certificate status has been updated.',
                                'success'
                            ).then(() => {
                                location.reload(); // Optionally, you can refresh the page
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while updating the status.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
        $(document).on('click', '.delete-student', function() {
            var id = $(this).data('id');
            var url = '{{ route('student.destroy', ':id') }}';
            url = url.replace(':id', id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085D6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Student has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload(); // Optionally, you can refresh the page
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the student.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>