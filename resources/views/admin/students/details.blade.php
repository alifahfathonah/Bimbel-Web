@extends('admin.layouts.main')

@section('title', 'Student Details')

@section('content')

<!-- Page Heading -->
<div class="row justify-content-between align-items-center">
    <h2 class="ml-3 text-gray-800">Student Details</h2>
</div>

@if (session('status'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    </div>
</div>
@endif

@if (session('errors'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger">
            {{ session('errors') }}
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <img class="img-fluid" src="{{ asset('img/user.png') }}" alt="{{ $student['name'] }}">
            </div>
            <div class="card-footer">
                <div class="d-flex flex-column justify-content-between">
                    <a href="#" class="btn btn-primary mb-3 disabled">Change Picture</a>
                    <a href="#" class="btn btn-danger disabled">Delete Picture</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <form action="{{ route('admin.student.update') }}" method="post">
            @csrf
            <div class="card">
                <div class="card-body">

                    <div class="form-group row">
                        <label for="id" class="col-sm-3 col-form-label">Student ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="id" placeholder="Student ID" value="{{ $student['id'] }}" disabled>
                            <input type="hidden" name="id" value="{{ $student['id'] }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" placeholder="Username" value="{{ $student['username'] }}">
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Name" value="{{ $student['name'] }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="offset-3 col-sm-9">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="password_enable"
                                    name="password_enable" {{ $student->password_enable == 1 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="password_enable">Enable Password</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.student.index') }}"class="btn btn-primary float-left px-4">Reset Password</a>
                    <button type="submit" class="btn btn-primary float-right px-4">Save</button>
                    <a href="{{ route('admin.student.index') }}" class="btn btn-primary float-right mx-4 px-4">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
