@extends('admin.layouts.app')

@section('title', 'Teacher Details')

@section('content')

<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center">
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
</div>

<div class="row">
    @include('admin.teachers.teacher_details')
</div>

@endsection
