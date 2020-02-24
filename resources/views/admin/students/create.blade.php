@extends('admin.layouts.app')

@section('title', 'New Students')

@section('content')

<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center my-3">
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
</div>
<hr>

@if(session('errors'))
    @component('components.alert', ['type' => 'danger'])
        {{ session('errors')->first() }}
    @endcomponent
@endisset

<div class="row">
    @component('components.card_border_left', ['type' => 'primary', 'class' => 'col-md-6 col-12'])
    @slot('header')
        <h5 class="m-0">Create Student</h5>
        <form action="{{ route('admin.students.index') }}" method="post">
    @endslot
        @include('admin.students.student_form', ['except' => ['id']])
    @slot('footer')
        <button type="submit" class="btn btn-primary float-right">Submit</button>
        </form>
    @endslot
    @endcomponent
@endsection
