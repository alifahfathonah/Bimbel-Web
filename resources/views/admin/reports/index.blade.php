@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')
<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center my-3">
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
</div>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@include('admin.reports.report_table')

@endsection
