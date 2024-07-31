@extends('layouts.admin')

@section('content') 

<!-- Main content -->
<div class="row">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- General Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                
                <h1>Student Details</h1>
                <table border="1">
                    <tr>
                        <th>ID</th>
                        <td>{{ $student->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ $student->mobile }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $student->email }}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>{{ $student->state_name }}</td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td>{{ $student->city_name }}</td>
                    </tr>
                    <tr>
                        <th>Grade</th>
                        <td>{{ $student->class_name }}</td>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <td>{{ $student->course_name }}</td>
                    </tr>
                    <tr>
                        <th>Course Type</th>
                        <td>{{ $student->course_type }}</td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td>{{ $student->duration }}MONTHS</td>
                    </tr>
                    <tr>
                        <th>Course Fees</th>
                        <td>{{ $student->course_fees }}</td>
                    </tr>
                    <!-- Add more details as needed -->
                </table>
                <a href="{{ route('student.index') }}">Back to Student List</a>
                
            </div>
        </div>
    </div>
</div>



@endsection
