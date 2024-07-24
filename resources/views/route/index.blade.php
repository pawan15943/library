@extends('layouts.admin')
@section('content')

<!-- Content Header (Page header) -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    
    <a href="{{ route('route.create') }}">Add Route</a> 
</div>

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
                            <table class="table table-hover border data-table" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th>Center</th>
                                        <th style="width: 20% "> Name</th>
                                        <th>Area</th>
                                        <th>Distance</th>
                                        <th style="width: 20% ">Action</th>
                                    </tr>
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
<!-- /.row (main row) -->
  
<!-- /.content -->

<script type="text/javascript">
 $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('route.index') }}",
                lengthMenu: [
                    [10, 50, 100, -1],
                    [10, 50, 100, "All"]
                ],
                columns: [
                    
                    {
                        data: 'center',
                        name: 'center'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                  
                    {
                        data: 'areas',
                        name: 'areas',
                        
                    },
                    {
                        data: 'distance',
                        name: 'distance',
                        
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                  

                ],
                 dom: 'lBfrtip',
                buttons: [
                    'excel', 'csv', 'pdf', 'copy'
                ]
            });

        });
   

</script>


@endsection
