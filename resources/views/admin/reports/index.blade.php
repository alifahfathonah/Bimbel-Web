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


@component('components.custom_card', ['type' => 'warning', 'class' => 'w-100'])

<div class="col-12">
    <div>
        <div class="text-xl font-weight-bold text-warning text-uppercase my-1 d-inline-block">
            Reports
        </div>
        <div class="btn-group d-inline-block float-right">
            <button type="button" class="btn btn-outline-warning dropdown-toggle px-5" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                All
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Today</a>
                <a class="dropdown-item" href="#">This Week</a>
                <a class="dropdown-item" href="#">This Month</a>
                <a class="dropdown-item" href="#">This Year</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Custom</a>
            </div>
        </div>
    </div>
    <hr>

    @include('admin.reports.report_table')

</div>

@endcomponent

@endsection
