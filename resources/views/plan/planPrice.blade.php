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
                    
                    <div class="row mt-3">
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label> Plan Name<sup class="text-danger">*</sup></label>
                                <select name="plan_id" id="plan_id" class="form-control @error('plan_id') is-invalid @enderror event">
                                    <option value="">Select Plan</option>
                                    @foreach ($plans as $value)
                                        <option value="{{ $value->id }}"
                                            {{ isset($planPrice) && $planPrice->plan_id == $value->id ? 'selected' : '' }}>
                                            @if($value->name==12)
                                            Yearly
                                            @else
                                            {{ $value->name }} 
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                
                                @error('plan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
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
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label> Plan Price<sup class="text-danger">*</sup></label>
                                <input type="text" name="price" class="form-control digit-only @error('price') is-invalid @enderror" id="" placeholder="Enter Price" value="{{ old('price', isset($planPrice) ? $planPrice->price : '') }}">
                                @error('price')
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
        <div class="card card-default main_card_content" id="generalInfo ">
            
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive tableRemove_scroll mt-2">
                           
                            <table class="table table-hover border data-table" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 20% "> Plan Name</th>
                                        <th style="width: 20% "> Plan Type</th>
                                        <th style="width: 20% "> Plan Price</th>
                                        <th style="width: 20% ">Action</th>
                                    </tr>
                                   @foreach($planPrice_list as $key => $value)
                                   <tr class="text-center">
                                    <td style="width: 20% "> {{$value->plan_name}} </td>
                                    <td style="width: 20% "> {{$value->plan_type}}</td>
                                    <td style="width: 20% "> {{$value->price}}</td>
                                    <td style="width: 20% "><a href="{{route('planPrice.edit', $value->id)}}"class="btn tooltips btn-default p-2 btn-sm rounded mr-2" title="Edit Price"><i class="fas fa-edit"></i></a></td>
                                    </tr>
                                   @endforeach
                                   
                                </thead>
                                <tbody>
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
       
        $('#plan_id').on('change', function(event){
            event.preventDefault();
            var plan_id = $(this).val();
           
            
            if(plan_id){
                $.ajax({
                        url: '{{ route('gettypePlanwise') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        type: 'GET',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "plan_id": plan_id,
                           
                        },
    
                        dataType: 'json',
                        success: function (html) {
                            
                            if(html){
                                $("#plan_type_id").empty();
                                $("#plan_type_id").append('<option value="">Select Plan Type</option>');
                                 $.each(html,function(key,value){
                                   
                                    $("#plan_type_id").append('<option value="'+key+'">'+value+'</option>');
                                });
                            }else{
                                
                                $("#plan_type_id").append('<option value="">Select Plan Type</option>');
                            }
                             
                        }
                    });
            }else{
                $("#plan_type_id").empty();
                $("#plan_type_id").append('<option value="">Select Plan Type</option>');
            }
        });
        
    });
        
    </script>
@endsection
