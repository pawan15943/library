@extends('layouts.admin')
@section('content')

<!-- Content Header (Page header) -->
@php
    $current_route = Route::currentRouteName();
@endphp
<!-- Main row -->
<div class="row ">
    <!-- Main Info -->
    <div class="col-lg-12 ">

        <!-- Add Document -->
        <div class="card card-default main_card_content" id="generalInfo ">
            
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="table-responsive tableRemove_scroll mt-2">
                           
                            @if($current_route=='planType.index')
                            <table class="table table-hover border data-table" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 20% "> Plan Type</th>
                                        <th style="width: 20% ">Action</th>
                                    </tr>
                                    @foreach($plan as $key => $value)
                                    <tr class="text-center">
                                        <td style="width: 20% "> {{$value->name}}</td>
                                        <td style="width: 20% "><a href="{{route('planType.edit', $value->id)}}"class="btn tooltips btn-default p-2 btn-sm rounded mr-2" title="Edit Route"><i class="fas fa-edit"></i></a></td>
                                    </tr>
                                    @endforeach
                                   
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            @elseif($current_route=='planPrice.index')
                           
                            <table class="table table-hover border data-table" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 20% "> Plan Name</th>
                                        <th style="width: 20% "> Plan Type</th>
                                        <th style="width: 20% "> Plan Price</th>
                                        <th style="width: 20% ">Action</th>
                                    </tr>
                                   @foreach($planPrice as $key => $value)
                                   <tr class="text-center">
                                    <td style="width: 20% "> {{$value->plan_name}}</td>
                                    <td style="width: 20% "> {{$value->plan_type}}</td>
                                    <td style="width: 20% "> {{$value->price}}</td>
                                    <td style="width: 20% "><a href="{{route('planPrice.edit', $value->id)}}"class="btn tooltips btn-default p-2 btn-sm rounded mr-2" title="Edit Price"><i class="fas fa-edit"></i></a></td>
                                    </tr>
                                   @endforeach
                                   
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            @else
                            <table class="table table-hover border data-table" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 20% "> Name</th>
                                        <th style="width: 20% ">Action</th>
                                    </tr>
                                    
                                    @foreach($plan as $key => $value)
                                    <tr class="text-center">
                                        <td style="width: 20% "> {{$value->name}}</td>
                                        <td style="width: 20% "><a href="{{route('plan.edit', $value->id)}}"class="btn tooltips btn-default p-2 btn-sm rounded mr-2" title="Edit Route"><i class="fas fa-edit"></i></a></td>
                                    </tr>
                                    @endforeach
                                   
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

    </div>

</div>
<!-- /.row (main row) -->
  
<!-- /.content -->

<script type="text/javascript">
 
</script>


@endsection
