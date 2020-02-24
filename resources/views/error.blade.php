@extends('tryout.layouts.app')

@section('title', $title)

@section('app')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="text-center">
            <div class="error mx-auto" data-text="{{ $error['code'] ?? '404' }}">{{ $error['code'] ?? '404' }}</div>
            <p class="lead text-gray-800 mb-5">{{ $error['title'] ?? 'Page Not Found' }}</p>
            <p class="text-gray-500 mb-0">{{ $error['message'] ?? '' }}</p>
            <a href="{{ $error['back'] ?? '' }}">&larr; {{ $error['url_title'] ?? 'Back to Dashboard' }}</a>
        </div>
    </div>
</div>

@endsection
