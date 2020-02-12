@extends('admin.layouts.app')

@section('title', 'Teacher Details')

@section('content')

<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center">
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
</div>

<div class="row">
    <div class="col-md-6">
        .<div class="card">
            <div class="card-header">
                {{ $user['name'] }}
            </div>
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="d-flex flex-column">
                        <p class="m-0">Name</p>
                        <p class="m-0">Teacher ID</p>
                        <p class="m-0">Username</p>
                        <p class="m-0">Email</p>
                        <p class="m-0">Join at</p>
                    </div>
                    <div class="d-flex flex-column mx-3">
                        <p class="m-0">: {{ $user['name'] }} </p>
                        <p class="m-0">: {{ $user['id'] }} </p>
                        <p class="m-0">: {{ $user['username'] }} </p>
                        <p class="m-0">: {{ $user['email'] }} </p>
                        <p class="m-0">: {{ toCarbon($user['created_at'])->toDayDateTimeString() }} </p>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-warning disabled">Reset Password</a>
                <a href="{{ route('admin.teachers.edit', ['teacher'=> $user['id']]) }}" class="btn btn-primary float-right disabled">Edit</a>
                <form action="{{ route('admin.teachers.destroy', ['teacher' => $user['id']]) }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
