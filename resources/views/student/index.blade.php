@extends('layouts.admin') 
@section('content') 
<div>
    <a href="{{route('student.create')}}">Add Student</a>
</div>

<!-- Main row -->
<div class="row">
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

                                        <th style="width: 20% ">Student Name</th>
                                        <th>Mobile No. </th>
                                        <th>Email </th>
                                        <th>City</th>
                                        <th>Course</th>
                                        <th>Course Type</th>
                                        <th>Grade</th>
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
            processing: true
            , serverSide: true
            , ajax: "{{ route('student.index') }}"
            , lengthMenu: [
                [10, 50, 100, -1]
                , [10, 50, 100, "All"]
            ]
            , columns: [

                 {
                    data: 'name'
                    , name: 'name'
                },

                {
                    data: 'mobile'
                    , name: 'mobile'
                    , searchable: false
                },
                {
                    data: 'email'
                    , name: 'email'
                    , searchable: true
                    , visible: false
                },

                {
                    data: 'city_name'
                    , name: 'city_name'
                    , searchable: false
                },
                {
                    data: 'course_name'
                    , name: 'course_name'
                    , searchable: false
                },
                {
                    data: 'course_type'
                    , name: 'course_type'
                    , searchable: false
                },
                {
                    data: 'class_name'
                    , name: 'class_name'
                    , searchable: false
                }
                , {
                    data: 'action'
                    , name: 'action'
                    , orderable: false
                    , searchable: false
                },

            ]
            , dom: 'lBfrtip'
            , buttons: [
                'excel', 'csv', 'pdf', 'copy'
            ]
        });

    });

</script>


@endsection
