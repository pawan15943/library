<script>
    // jQuery script
    $(document).ready(function() {
        $('.first_popup').on('click', function() {
            var seatId = $(this).attr('id');
            $('#seat_no').val(seatId);
            $('#seat_no_head').text('Book Seat No ' + seatId);
            $('#seatAllotmentModal').modal('show');

            
            if (seatId) {
                $.ajax({
                    url: '{{ route('gettypeSeatwise') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "seatId": seatId,
                    },
                    dataType: 'json',
                    success: function (html) {
                       console.log(html);
                        if (html) {
                            $("#plan_type_id").empty();
                            $("#plan_type_id").append('<option value="">Select Plan Type</option>');
                            $.each(html, function(key, value) {
                               
                                $("#plan_type_id").append('<option value="'+key+'">'+value+'</option>');
                            });
                        } else {
                            $("#plan_type_id").append('<option value="">Select Plan Type</option>');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", status, error); // Log any errors
                    }
                    });
            } else {
                    $("#plan_type_id").empty();
                    $("#plan_type_id").append('<option value="">Select Plan Type</option>');
            }
        });
        $('.second_popup').on('click', function() {
            var seatId = $(this).attr('id');
            $('#seatAllotmentModal2').modal('show');
            $('#user_id').val(seatId);
           
            if (seatId) {
                $.ajax({
                    url: '{{ route('geUser')}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": seatId,
                    },
                    dataType: 'json',
                    success: function(html) {
            
                        $('#owner').text(html.name);
                        if (html.id_proof_name == 1) {
                            var proof = 'Aadhar';
                        } else if (html.id_proof_name == 2) {
                            var proof = 'Driving License';
                        } else {
                            var proof = 'Other';
                        }
                        
                        $('#proof').text(proof);
                        $('#planName').text(html.plan_name);
                        $('#planTypeName').text(html.plan_type_name);
                        $('#joinOn').text(html.join_date);
                        $('#startOn').text(html.plan_start_date);
                        $('#endOn').text(html.plan_end_date);
                        $('#price').text(html.plan_price_id);
                        $('#seat_name').text(html.seat_no);
                        $('#planTiming').text(html.start_time+' to '+html.end_time);
                        $('#seat_details_info').text('Booking Details of Seat No. : ' + html.seat_no);
                    }
                });
            }


        });
        $('#upgrade').on('click', function() {
           
            var user_id = $('#user_id').val();
            var seat_no_id = $('#seat_name').text().trim();

            var endOnDate = $('#endOn').text().trim();

            // Hide the first modal
            $('#seatAllotmentModal2').modal('hide');

            // Update the fields in the second modal
            $('#update_plan_end_date').val(endOnDate);
            $('#update_seat_no').val(seat_no_id);
            $('#update_user_id').val(user_id);
            $('#seat_number_upgrades').text('Upgrade Seat No. : '  + seat_no_id);
            // Show the second modal
            $('#seatAllotmentModal3').modal('show');
        
            if (seat_no_id && user_id) {
                $.ajax({
                    url: '{{ route('gettypePlanwise') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "seat_no_id": seat_no_id,
                        "user_id": user_id,
                    },
                    dataType: 'json',
                    success: function (html) {
                        // console.log(html);
                        if (html) {
                       
                            $.each(html, function(key, value) {
                                $("#updated_plan_type_id").append('<option value="'+key+'">'+value+'</option>');
                            });
                        } else {
                            $("#updated_plan_type_id").append('<option value="">Select Plan Type</option>');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", status, error); // Log any errors
                    }
                    });
            } else {
                    $("#updated_plan_type_id").empty();
                    $("#updated_plan_type_id").append('<option value="">Select Plan Type</option>');
            }
        });
      

        $('#plan_type_id').on('change', function(event) {
            event.preventDefault();
            var plan_type_id = $(this).val();
            var plan_id = $('#plan_id').val();

            if (plan_type_id && plan_id) {
                $.ajax({
                    url: '{{ route('getPricePlanwise') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "plan_type_id": plan_type_id,
                        "plan_id": plan_id,
                    },
                    dataType: 'json',
                    success: function(html) {
                             $.each(html, function(key, value) {
                                $("#plan_price_id").val(value);
                            });
                     
                    }
                });
            } else {
                $("#plan_price_id").empty();
               
            }
        });

        $('#update_plan_id').on('change', function(event) {
            event.preventDefault();
            var update_plan_type_id = $('#updated_plan_type_id').val();
            var update_plan_id =$(this).val();

            if (update_plan_id && update_plan_type_id) {
                $.ajax({
                    url: '{{ route('getPricePlanwiseUpgrade') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "update_plan_type_id": update_plan_type_id,
                        "update_plan_id": update_plan_id,
                    },
                    dataType: 'json',
                    success: function(html) {
                        $.each(html, function(key, value) {
                            $("#updated_plan_price_id").val(value);
                        });
                    }
                });
            } else {
                $("#updated_plan_price_id").empty();
                $("#updated_plan_price_id").append('<option value="">Select Plan Price</option>');
            }
        });

        $(document).on('submit', '#seatAllotmentForm', function(event) {
            event.preventDefault();


            var formData = new FormData(this);
            var seat_no = $('#seat_no').val();
            var name = $('#name').val();
            var mobile = $('#mobile').val();
            var email = $('#email').val();
            var dob = $('#dob').val();
            var plan_id = $('#plan_id').val();
            var plan_type_id = $('#plan_type_id').val();
            var plan_start_date = $('#plan_start_date').val();
            var id_proof_name = $('#id_proof_name').val();
            var id_proof_file = $("#id_proof_file")[0].files[0];

            var errors = {};

            if (!name) {
                errors.name = 'Full Name is required.';
            }
            if (!mobile) {
                errors.mobile = 'Mobile number is required.';
            }
            if (!email) {
                errors.email = 'Email Id is required.';
            }
            if (!dob) {
                errors.dob = 'Date of Birth is required.';
            }
            if (!plan_id) {
                errors.plan_id = 'Plan is required.';
            }
            if (!plan_type_id) {
                errors.plan_type_id = 'Plan Type is required.';
            }
            if (!plan_start_date) {
                errors.plan_start_date = 'Plan Start Date is required.';
            }

            // Remove previous errors
            $(".is-invalid").removeClass("is-invalid");
            $(".invalid-feedback").remove();

            // Show new errors
            if (Object.keys(errors).length > 0) {
                $.each(errors, function(key, value) {
                    var inputField = $("#" + key);
                    inputField.addClass("is-invalid");
                    inputField.after('<div class="invalid-feedback">' + value + '</div>');
                });
                return;
            }


            formData.append('_token', '{{ csrf_token() }}');
            formData.append('plan_id', plan_id);
            formData.append('plan_type_id', plan_type_id);
            formData.append('id_proof_name', id_proof_name);

            $.ajax({
                url: '{{ route('customers.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {

                    if (response.success) {

                        Swal.fire({
                            title: 'Success!',
                            text: 'Form submission successful',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(true); // Force reload from the server
                        });
                    } else if (response.errors) {
                        $(".is-invalid").removeClass("is-invalid");
                        $(".invalid-feedback").remove();
                        $("#error-message").hide();

                        $.each(response.errors, function(key, value) {
                            var inputField = $("input[name='" + key + "'], select[name='" + key + "']");
                            inputField.addClass("is-invalid");
                            inputField.after('<div class="invalid-feedback">' + value[0] + '</div>');
                        });
                    } else {
                        $("#error-message").text(response.message).show();
                        $("#success-message").hide();
                    }
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {
                        var response = xhr.responseJSON;
                        $(".is-invalid").removeClass("is-invalid");
                        $(".invalid-feedback").remove();
                        $("#error-message").hide();

                        $.each(response.errors, function(key, value) {
                            var inputField = $("input[name='" + key + "'], select[name='" + key + "']");
                            inputField.addClass("is-invalid");
                            inputField.after('<div class="invalid-feedback">' + value[0] + '</div>');
                        });
                    } else {
                        $("#error-message").text('Something went wrong. Please try again.').show();
                        $("#success-message").hide();
                    }
                }
            });


        });

        $(document).on('submit', '#upgradeForm', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var seat_no = $('#update_seat_no').val();
            var user_id = $('#update_user_id').val();
            var plan_id = $('#update_plan_id').val();

            var plan_type_id = $('#updated_plan_type_id').val();
            var plan_price_id = $('#updated_plan_price_id').val();
            var errors = {};

            if (!plan_id) {
                errors.plan_id = 'Plan is required.';
            }
            if (!plan_type_id) {
                errors.plan_type_id = 'Plan Type is required.';
            }

            if (!plan_price_id) {
                errors.plan_price_id = 'Price is required.';
            }

            if (Object.keys(errors).length > 0) {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                $.each(errors, function(key, value) {
                    var inputField = $("#" + key);
                    inputField.addClass("is-invalid");
                    inputField.after('<div class="invalid-feedback">' + value + '</div>');
                });
                return; // Exit the function if there are validation errors
            }

            formData.append('_token', '{{ csrf_token() }}');
            formData.append('seat_no', seat_no);
            formData.append('user_id', user_id);
            formData.append('plan_id', plan_id);
            formData.append('plan_type_id', plan_type_id);
            formData.append('plan_price_id', plan_price_id);


            $.ajax({
                url: '{{ route('user.update') }}', // Update this URL to your route for updating seats
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {

                    if (response.success) {

                        $("#success-message").text('Form submission successful').show();
                        $("#error-message").hide();
                        setTimeout(function() {
                            window.location.href = '{{ route('seats') }}';
                            location.reload(true); // Force reload from the server
                        }, 2000); // Delay for 2 seconds before redirecting
                    } else if (response.errors) {
                        $(".is-invalid").removeClass("is-invalid");
                        $(".invalid-feedback").remove();
                        $("#error-message").hide();

                        $.each(response.errors, function(key, value) {
                            var inputField = $("input[name='" + key + "'], select[name='" + key + "']");
                            inputField.addClass("is-invalid");
                            inputField.after('<div class="invalid-feedback">' + value[0] + '</div>');
                        });
                    } else {
                        $("#error-message").text(response.message).show();
                        $("#success-message").hide();
                    }
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {
                        var response = xhr.responseJSON;
                        $(".is-invalid").removeClass("is-invalid");
                        $(".invalid-feedback").remove();
                        $("#error-message").hide();

                        $.each(response.errors, function(key, value) {
                            var inputField = $("input[name='" + key + "'], select[name='" + key + "']");
                            inputField.addClass("is-invalid");
                            inputField.after('<div class="invalid-feedback">' + value[0] + '</div>');
                        });
                    } else {
                        $("#error-message").text('Something went wrong. Please try again.').show();
                        $("#success-message").hide();
                    }
                }
            });
        });

    });
</script>