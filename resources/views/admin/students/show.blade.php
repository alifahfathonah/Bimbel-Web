@extends('admin.layouts.app')

@section('title', 'Student Details')

@section('content')

<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center">
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
</div>

<div class="row">
    <div class="col-md-6">
        @include('admin.students.student_details')
    </div>
</div>

<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center mt-5">
    <h1 class="h3 mb-2 text-gray-800">Student Reports</h1>
</div>

@include('admin.reports.report_table', [
    'reports' => $reports,
    'student' => $student,
    'colums' => ['Course','Start Time','Time Spent','Status','Score','Action']
])

@endsection
