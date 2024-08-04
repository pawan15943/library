@extends('layouts.admin')
@section('content')

<!-- Main content -->

<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- Genral Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                <form action="{{ isset($planPrice) ? route('planPrice.update', $planPrice->id) : route('planPrice.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($planPrice))
                    @method('PUT')
                    @endif

                    <div class="row g-4">
                        <div class="col-lg-4">
                            <label> Plan Name<sup class="text-danger"></sup></label>
                            <select name="plan_id" id="plan_id" class="form-control @error('plan_id') is-invalid @enderror event">
                                <option value="">Select Plan</option>
                                @foreach ($plans as $value)
                                <option value="{{ $value->id }}" {{ isset($planPrice) && $planPrice->plan_id == $value->id ? 'selected' : '' }}>
                                    {{ $value->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('plan_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <label> Plan Type<sup class="text-danger">*</sup></label>
                            <select name="plan_type_id" id="plan_type_id" class="form-control @error('plan_type_id') is-invalid @enderror event">
                                <option value="">Select Plan Type</option>
                                @foreach($plantypes as $planType)
                                <option value="{{ $planType->id }}" {{ isset($planPrice) && $planPrice->plan_type_id == $planType->id ? 'selected' : '' }}>
                                    {{ $planType->name }}
                                </option>
                                @endforeach
                                @error('plan_type_id')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label> Plan Price<sup class="text-danger">*</sup></label>
                            <input type="text" name="price" class="form-control digit-only @error('price') is-invalid @enderror" id="" placeholder="Enter Price" value="{{ old('price', isset($planPrice) ? $planPrice->price : '') }}">
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <input type="submit" class="btn btn-primary btn-block" value="Submit">
                        </div>

                    </div>

                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-default main_card_content" id="generalInfo ">

            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="px-3">All Plans Price List</h4>

                        <div class="table-responsive tableRemove_scroll mt-2" >

                            <table class="table table-hover data-table m-0 d-inline" id="datatable" style="display:table !important">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Plan Name</th>
                                        <th>Plan Type</th>
                                        <th>Plan Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $x=1;
                                    @endphp
                                    @foreach($planPrice_list as $key => $value)
                                    <tr>
                                        <td> {{$x}} </td>
                                        <td> {{$value->plan_name}} </td>
                                        <td> {{$value->plan_type}}</td>
                                        <td> {{$value->price}}</td>
                                        <td><a href="{{route('planPrice.edit', $value->id)}}" title="Edit Price"><i class="fas fa-edit"></i></a></td>
                                    </tr>
                                    @endforeach

                                
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<!-- /.content -->
<script type="text/javascript">

    $(document).ready(function() {

        $('#plan_id').on('change', function(event) {
            event.preventDefault();
            var plan_id = $(this).val();


            if (plan_id) {
                $.ajax({
                    url: '{{ route('gettypePlanwise')}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "plan_id": plan_id,

                    },

                    dataType: 'json',
                    success: function(html) {

                        if (html) {
                            $("#plan_type_id").empty();
                            $("#plan_type_id").append('<option value="">Select Plan Type</option>');
                            $.each(html, function(key, value) {

                                $("#plan_type_id").append('<option value="' + key + '">' + value + '</option>');
                            });
                        } else {

                            $("#plan_type_id").append('<option value="">Select Plan Type</option>');
                        }

                    }
                });
            } else {
                $("#plan_type_id").empty();
                $("#plan_type_id").append('<option value="">Select Plan Type</option>');
            }
        });

    });
</script>
@endsection