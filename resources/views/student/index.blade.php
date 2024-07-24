@extends('layouts.admin')

@section('content')

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

                                        <th>Form No</th>
                                        <th style="width: 20% ">Student Name</th>
                                        <th>Country</th>
                                        <th>Grade</th>
                                        <th>Stream</th>
                                        <th>Fee </th>
                                        <th>Mobile No. </th>
                                        <th>Email </th>
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
                    data: 'form_num'
                    , name: 'form_num',
                    searchable: true

                }
                , {
                    data: 'name'
                    , name: 'name'
                },

                {
                    data: 'countries_name'
                    , name: 'countries_name'
                    , searchable: false
                },

                {
                    data: 'classes_name'
                    , name: 'classes_name'
                    , searchable: false
                }
                , {
                    data: 'stream'
                    , name: 'stream',

                }
                , {
                    data: 'fee_status'
                    , name: 'fee_status',

                }
                , {
                    data: 'mobile_no'
                    , name: 'mobile_no'
                    , searchable: true
                    , visible: false
                }
                , {
                    data: 'email'
                    , name: 'email'
                    , searchable: true
                    , visible: false
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
