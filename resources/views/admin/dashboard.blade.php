@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Page Heading -->
<div class="row">
    <h2 class="ml-3 mb-0 text-gray-800">@yield('title')</h2>
</div>
<hr class="my-1">

<div class="row mt-3">

    @component('components.custom_card', [
        'type' => 'primary',
        'title' => 'Active Teachers',
        'value' => "$user_count Teachers",
        'icon' => 'fas fa-user-tie',
    ])
    @endcomponent

    @component('components.custom_card', [
        'type' => 'success',
        'title' => 'Active Students',
        'value' => "$student_count Students",
        'icon' => 'fas fa-user-graduate',
    ])
    @endcomponent

    @component('components.custom_card', [
        'type' => 'warning',
        'title' => 'Reports',
        'value' => "$report_count Reports",
        'icon' => 'fas fa-tasks',
    ])
    @endcomponent

    @component('components.custom_card', [
        'type' => 'info',
        'title' => 'Exams',
        'value' => "$exam_count Exams",
        'icon' => 'fas fa-file-alt',
    ])
    @endcomponent

</div>

<div class="row align-items-start">

    @component('components.custom_card', [
        'type' => 'warning',
        'class' => 'col-md-9',
    ])
        <div class="col-12">
            <div class="text-xl font-weight-bold text-warning text-uppercase my-1">Reports Today</div>
            <hr>
            @include('admin.reports.report_table', ['reports' => $reports_today])
        </div>
    @endcomponent

    @component('components.pie_chart', [
        'title' => 'Report Score Status',
        'labels' => ['Report with Score Above Min', 'Report with Score Below Min'],
        'colors' => ['#28a745', '#dc3545'],
        'chart_data' => $chart_data,
    ])

    @endcomponent
</div>

@endsection
