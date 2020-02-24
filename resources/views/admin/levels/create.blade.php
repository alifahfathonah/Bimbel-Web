@extends('admin.layouts.app')

@section('title', 'Create Exam')

@section('content')

<!-- Page Heading -->
<div class="row">
    <h2 class="ml-3 mb-0 text-gray-800">@yield('title')</h2>
</div>
<hr class="mt-1 mb-4">

@if (session('status'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

@if(session('errors'))
@component('components.alert', ['type' => 'danger'])
{{ session('errors')->first() }}
@endcomponent
@endisset

@component('components.custom_card', ['type' => 'danger', 'class' => 'col-md-8'])
<div class="col-12">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-xl font-weight-bold text-danger text-uppercase mb-1">
            Create New Exam
            <small class="d-block text-capitalize text-secondary">{{ $course['title'] }} - {{ $level['title'] }}</small>
        </div>
    </div>
    <hr>
    <form action="{{ route('admin.sublevels.store') }}" method="post">
        @include('admin.levels.levels_form')
        <hr>
        <button type="submit" class="btn btn-primary px-3 float-right">Save</button>
        <a href="{{ route('admin.exams.level.show', ['level_id' => $level['id']]) }}" class="btn btn-danger mx-3 float-right">Cancel</a>
    </form>
</div>

@endcomponent

@endsection
