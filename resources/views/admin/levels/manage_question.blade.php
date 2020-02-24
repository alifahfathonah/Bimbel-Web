@extends('admin.layouts.app')

@section('title', 'Exams')

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

<div class="row px-3 align-items-start">
    <questions-list
        class="col-12"
        sublevel-title="{{ $sublevel['title'] }}"
        course-title="{{ $course['title'] }}"
        level-title="{{ $level['title'] }}"
        sublevel-id="{{ $sublevel['id'] }}"
        url-question-index="{{ route('admin.questions.index', ['sublevel_id' => $sublevel['id']]) }}"
        url-question-store="{{ route('admin.questions.store') }}">
    </questions-list>
</div>

@endsection


@push('js')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
