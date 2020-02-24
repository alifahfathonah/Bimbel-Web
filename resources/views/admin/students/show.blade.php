@extends('admin.layouts.app')

@section('title', 'Student Details')

@section('content')

<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center">
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
</div>
<hr>
<div class="row">
    @include('admin.students.student_details')
</div>

<div class="row mt-4">
    @component('components.card_border_left', ['type' => 'warning', 'class' => 'col-12'])
        @slot('header')
        <h5 class="m-0 text-warning">Student Reports</h5>
        @endslot
        @include('admin.reports.report_table', [
            'reports' => $reports,
            'student' => $student,
            'colums' => ['Course','Start Time','Time Spent','Status','Score','Action']
            ])
    @endcomponent
</div>
@endsection
