@extends('admin.layouts.app')

@section('title', 'Edit Student Data')

@section('content')

<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center my-3">
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
</div>

@if(session('errors'))
    @component('components.alert', ['type' => 'danger'])
        {{ session('errors')->first() }}
    @endcomponent
@endisset

<div class="row">
    <div class="col-md-8">
        <form action="{{ route('admin.students.update', ['student' => $student['id']]) }}" method="post">
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    {{ $student['name'] }}
                </div>
                <div class="card-body">

                    @include('admin.students.student_form')

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
