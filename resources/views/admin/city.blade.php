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
                    @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                    @endif
                    <div class="row">
                    <input type="hidden" name="id" value="" id="city_id">
                    <div class="col-lg-6">
                        <label> State <sup class="text-danger">*</sup></label>
                        <select id="stateid" name="state_id" class="form-control @error('state') is-invalid @enderror" placeholder="Select State">
                            @error('state')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <option value="">Select State</option>
                            @foreach ($states as $key => $state)
                            <option value="{{$state}}">{{$key}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label> City Name <sup class="text-danger">*</sup></label>
                        <input type="text" id="city" name="city_name" value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror" placeholder="City Name">
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary btn-block">Add City </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- City List -->
        <div class="card card-default main_card_content" id="generalInfo">
            <div class="card-body p-0">
                <h4 class="px-3 py-2">All Cities List</h4>
                <div class="table-responsive tableRemove_scroll mt-2">
                    <table class="table table-hover dataTable m-0" id="datatable" style="display:table !important">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>City Name</th>
                                <th>State </th>
                                <th>City Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php
                        $x=1;
                        @endphp
                        <tbody>
                            @foreach($citys as $key => $city)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$city->city_name}}</td>
                                <td>{{$city->state_name}}</td>
                                <td>
                                @if($city->is_active==1)
                                <div class="text-success">Active</div>
                                @else
                                <div class="text-danger">Inactive</div>
                                @endif
                                </td>
                                <td>
                                    <ul class="actionables">
                                        <li><a href="javascript:void(0)" type="button" class="city_edit" data-id="{{$city->city_id}}"><i class="fas fa-edit"></i></a></li>
                                        <li><a href="javascript:void(0)" type="button" class="delete" data-id="{{$city->city_id}}"><i class="fas fa-trash"></i></a></li>
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





<script type="text/javascript">
    $(document).ready(function() {
        $(document.body).on('submit', '#submit', function(event) {
            event.preventDefault();
            var state_id = $("#stateid").val();
            var city_name = $('#city').val();
            var city_id = $('#city_id').val();


            if (state_id == '' || state_id == undefined) {
                Swal.fire({
                    title: 'Error!',
                    text: 'State is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            if (city_name == '' || city_name == undefined) {
                Swal.fire({
                    title: 'Error!',
                    text: 'City is required.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }


            $.ajax({
                url: '{{ route('city.store') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",

                    state_id: state_id,
                    city_name: city_name,
                    id: city_id,
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
                    } else if (response.errors) {

                        $(".is-invalid").removeClass("is-invalid");
                        $(".invalid-feedback").remove();

                        $.each(response.errors, function(key, value) {

                            if (key == 'city_name') {
                                $("#city").addClass("is-invalid");
                                $("#city").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                            }

                            if (key == 'state_id') {
                                $("#stateid").addClass("is-invalid");
                                $("#stateid").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
                            }

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

        $(document.body).on('click', '.city_edit', function() {
            var city_id = $(this).data('id');
            console.log(city_id);
            $.ajax({
                url: '{{ route('city.edit') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": city_id,

                },

                dataType: 'json',
                success: function(response) {

                    $('#city_id').val(response.city.id);
                    $('#city').val(response.city.city_name);
                    $("#stateid").val(response.city.state_id);
                }
            });

        });

        $('.delete').click(function(e) {
            if (!confirm('Are you sure you want to delete this City?')) {
                e.preventDefault();
            }
            var city_id = $(this).data('id');
            $.ajax({
                url: '{{ route('city.destroy') }}',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": city_id,

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
    });
</script>

@endsection