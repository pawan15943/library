@extends('layouts.admin')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />               
<div class="container-fluid">

    <!-- Page Heading -->
   
    <div class="card shadow mb-4 py-4">
        <div class="col-lg-12">
            <form id="submit" >
                @csrf
            
               
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="row g-4">
                    <input type="hidden" name="id" value="" id="state_id">
                  
                    <div class="col-lg-5">
                        <input type="text" id="state" name="state_name" value="{{ old('state') }}" class="form-control @error('state') is-invalid @enderror" placeholder="State Name"  >
                
                        @error('state')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                     </div>

                    <div class="col-lg-3">
                        <button type="submit"  class="btn btn-primary btn-block" >Add State</button>
                    </div>

                </div>
            
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">State List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>State Id</th>
                           
                            <th>State Name</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($states as $key => $state)
                        <tr>
                            <td>{{$state->state_id}}</td>
                           
                            <td>{{$state->state_name}}</td>
                            @if($state->is_active==1)
                            <td>Active</td>
                            @else
                            <td>Unactive</td>
                            @endif
                            <td><a href="javascript:void(0)" type="button" class="state_edit" data-id="{{$state->state_id}}">Edit</a>
                            
                            <form method="POST" action="{{ route('state.destroy', $state->state_id) }}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">

                                <button type="submit" class="delete" title='Delete'>Delete</button>
                            </form>
                            <td>
                            
                        </td>
                        </tr>
                        @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

<script type="text/javascript">
$(document).ready(function() {
    $(document.body).on('click','.state_edit',function(){
        var state_id=$(this).data('id');
            
            $.ajax({
                    url: '{{ route('state.edit') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": state_id,
                       
                    },

                    dataType: 'json',
                    success: function (response) {
                      
                        $('#state').val(response.state.state_name);
                        $('#countryid').val(response.state.country_id);
                        $('#state_id').val(response.state.id);
                        
                    }
                });

    });
     $(document.body).on('submit','#submit',function(){
       
            event.preventDefault();
         
          
            var state_name = $('#state').val();
            var state_id=$('#state_id').val();
          
            if(state_name=='' || state_name==undefined){
                Swal.fire({
                    title: 'Error!',
                    text: 'State Name is required.', 
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
           

                $.ajax({
                    url: '{{ route('state.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                      
                        state_name: state_name,
                        id:state_id,
                    },

                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success'
                            }).then(function () {
                                location.reload();
                            });
                        } else if (response.errors) {
                          
                            $(".is-invalid").removeClass("is-invalid");
                            $(".invalid-feedback").remove();

                            $.each(response.errors, function (key, value) {
                            
                                if(key=='state_name'){
                                    $("#state" ).addClass("is-invalid");
                                    $("#state").after('<span class="invalid-feedback" role="alert">' + value + '</span>');
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

     $('.delete').click(function(e) {
        if(!confirm('Are you sure you want to delete this State?')) {
            e.preventDefault();
        }
     });
    });
</script>
               
 @endsection