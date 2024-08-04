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
                    <div class="d-flex action-heading">
                        <!-- <h4>Student List</h4> -->
                        <a href="{{route('student.create')}}" class="button"><i class="fa-solid fa-plus"></i> Student</a>
                       
                    </div>
                        <div class="table-responsive tableRemove_scroll mt-2">
                            <table class="table table-hover border data-table" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th>ID</th>
                                        <th style="width: 20% ">Student Name</th>
                                        <th>Contact Info </th>
                                        <th>Course</th>
                                        <th>Is Paid</th>
                                        <th>Is Completed</th>
                                        <th>Is Certificate Issued</th>
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
            ajax: "{{ route('student.index') }}",
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
            columns: [
                {
                    data: 'form_no',
                    name: 'form_no',
                    searchable: false
                },
                {
                    data: null,
                    name: 'name_gender',
                    render: function(data, type, row) {
                        return row.name + '<br>' + row.gender;
                    },
                    orderable: true,
                    searchable: true
                },
                {
                    data: null,
                    name: 'contact_info',
                    render: function(data, type, row) {
                        return row.mobile + '<br>' + row.email;
                    },
                    orderable: true,
                    searchable: true
                },
                {
                    data: null,
                    name: 'course_info',
                    render: function(data, type, row) {
                        return row.course_name + '<br> Duration: ' + row.duration + '<br> Fees: ' + row.course_fees;
                    },
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'is_paid',
                    name: 'is_paid',
                    searchable: false
                },
                {
                    data: 'is_completed',
                    name: 'is_completed',
                    searchable: false
                },
                {
                    data: 'is_certificate',
                    name: 'is_certificate',
                    searchable: false
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

    $(document).on('click', '.toggle-active', function() {
           
            var id = $(this).data('id');
            var url = '{{ route('students.toggleActive', ':id') }}'; // Use placeholder for ID
            url = url.replace(':id', id); // Replace placeholder with actual ID
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change the active status of this student?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url , // Correct URL
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Updated!',
                                'Student active status has been updated.',
                                'success'
                            ).then(() => {
                                location.reload(); // Optionally, you can refresh the page
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while updating the status.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
       
        // Toggle Certificate Status
        $(document).on('click', '.toggle-certificate', function() {
            var id = $(this).data('id');
            var url = '{{ route('students.toggleCertificate', ':id') }}'; // Use placeholder for ID
            url = url.replace(':id', id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change the certificate status of this student?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:url, // Correct URL
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Updated!',
                                'Student certificate status has been updated.',
                                'success'
                            ).then(() => {
                                location.reload(); // Optionally, you can refresh the page
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while updating the status.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
        $(document).on('click', '.delete-student', function() {
        var id = $(this).data('id');
        var url = '{{ route('student.destroy', ':id') }}';
        url = url.replace(':id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'Student has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Optionally, you can refresh the page
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the student.',
                            'error'
                        );
                    }
                });
            }
        });
    });

</script>

@endsection
