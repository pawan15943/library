@extends('layouts.admin')

@section('content')

<!-- Main content -->
<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">

        <!-- General Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                <a href="{{ route('student.index') }}" class="btn btn-primary button"><i class="fa fa-long-arrow-left"></i> Go Back</a>
                <div class="table-reponsive mt-4 ">
                    <table class="table table-bordered mb-0" id="detailsTable">
                        <thead>
                            <tr>
                                <th class="w-50">Field Name</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td>{{ $student->id }}</td>
                            </tr>
                            <tr>
                                <td>Student Photo</td>
                                <td class="uppercase">{{ $student->profile_image }}</td>
                            </tr>
                            <tr>
                                <td>Student Full Name</td>
                                <td class="uppercase">{{ $student->name }}</td>
                            </tr>
                            <tr>
                                <td>Student Father Name</td>
                                <td class="uppercase">{{ $student->father_name }}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td class="uppercase">{{ $student->gender }}</td>
                            </tr>
                            <tr>
                                <td>Student Mobile</td>
                                <td>{{ $student->mobile }}</td>
                            </tr>
                            <tr>
                                <td>Student Email</td>
                                <td>{{ $student->email }}</td>
                            </tr>
                            <tr>
                                <td>Student Address</td>
                                <td>{{ $student->address }}</td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td>{{ $student->state_name }}</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>{{ $student->city_name }}</td>
                            </tr>
                            <tr>
                                <td>Pincode</td>
                                <td>{{ $student->pin_code }}</td>
                            </tr>
                            <tr>
                                <td>Grade</td>
                                <td>{{ $student->class_name }}</td>
                            </tr>
                            <tr>
                                <td>Stream</td>
                                <td>{{ $student->stream }}</td>
                            </tr>
                            <tr>
                                <td>Course</td>
                                <td>{{ $student->course_name }}</td>
                            </tr>
                            <tr>
                                <td>Course Type</td>
                                <td>{{ $student->course_type }}</td>
                            </tr>
                            <tr>
                                <td>Duration</td>
                                <td>{{ $student->duration }}MONTHS</td>
                            </tr>
                            <tr>
                                <td>Course Fees</td>
                                <td>{{ $student->course_fees }}</td>
                            </tr>
                            <tr>
                                <td>Course Completion Status</td>
                                <td>{{ $student->status }}</td>
                            </tr>
                            <tr>
                                <td>Created At</td>
                                <td>{{ $student->created_at }}</td>
                            </tr>
                            <tr>
                                <td>Certificate Issued</td>
                                <td>{{ $student->is_certificate }}</td>
                            </tr>
                            <tr>
                                <td>Modified At</td>
                                <td>{{ $student->modified_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>



@endsection