@extends('layouts.admin')
@section('content')

<!-- Main content -->

<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- Genral Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">

                <form action="{{ isset($plan) ? route('plan.update', $plan->id) : route('plan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($plan))
                    @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-lg-6">
                            <label> Plan Name<sup class="text-danger">*</sup></label>
                            <select class="form-control @error('plan_id') is-invalid @enderror" name="plan_id">
                                <option value="1" {{ old('plan_id', isset($plan) ? $plan->plan_id : '') == 1 ? 'selected' : '' }}>1 MONTH</option>
                                <option value="3" {{ old('plan_id', isset($plan) ? $plan->plan_id : '') == 3 ? 'selected' : '' }}>3 MONTHS</option>
                                <option value="6" {{ old('plan_id', isset($plan) ? $plan->plan_id : '') == 6 ? 'selected' : '' }}>6 MONTHS</option>
                                <option value="9" {{ old('plan_id', isset($plan) ? $plan->plan_id : '') == 9 ? 'selected' : '' }}>9 MONTHS</option>
                                <option value="12" {{ old('plan_id', isset($plan) ? $plan->plan_id : '') == 12 ? 'selected' : '' }}>12 MONTHS</option>
                            </select>
                            @error('plan_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <label></label>
                            <input type="submit" class="btn btn-primary btn-block" value="Add Plan">
                        </div>
                    </div>

                </form>
            </div>
            <!-- /.card-body -->
            <div class="card card-default main_card_content" id="generalInfo ">
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="px-3">All Plans List</h4>
                            <div class="table-responsive tableRemove_scroll mt-2">
                                <table class="table dataTable border-0 m-0" id="datatable" style="display:table !important">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Plan Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $x = 1;
                                        @endphp
                                        @foreach($plans as $key => $value)
                                        <tr>
                                            <td>{{$x++}}</td>
                                            <td class="w-75">{{$value->name}}</td>
                                            <td><a href="{{route('plan.edit', $value->id)}}" title="Edit Route"><i class="fas fa-edit"></i></a></td>
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
</div>

<!-- /.content -->

@endsection