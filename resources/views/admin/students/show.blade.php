@extends('admin.layouts.app')

@section('title', 'Student Details')

@section('content')

<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center">
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
</div>

<div class="row">
    <div class="col-md-6">
        .<div class="card">
            <div class="card-header">
                {{ $student['name'] }}
            </div>
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="d-flex flex-column">
                        <p class="m-0">Name</p>
                        <p class="m-0">Student ID</p>
                        <p class="m-0">Username</p>
                        <p class="m-0">Join at</p>
                    </div>
                    <div class="d-flex flex-column mx-3">
                        <p class="m-0">: {{ $student['name'] }} </p>
                        <p class="m-0">: {{ $student['id'] }} </p>
                        <p class="m-0">: {{ $student['username'] }} </p>
                        <p class="m-0">: {{ toCarbon($student['created_at'])->toDayDateTimeString() }} </p>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-warning disabled">Reset Password</a>
                <a href="{{ route('admin.students.edit', ['student'=> $student['id']]) }}"
                    class="btn btn-primary float-right">Edit</a>
                <form action="{{ route('admin.students.destroy', ['student' => $student['id']]) }}" method="post"
                    class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
