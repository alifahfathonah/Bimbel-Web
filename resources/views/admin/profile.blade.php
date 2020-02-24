@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="row">
        <h2 class="ml-3 text-gray-800">Profile</h2>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">User Picture</h5>
                </div>
                <div class="card-body">
                    <img class="img-fluid" src="{{ asset('img/user.png') }}" alt="{{ $user['name'] }}">
                </div>
                <div class="card-footer">
                    <div class="d-flex flex-column justify-content-between">
                        <a href="#" class="btn btn-primary mb-3 disabled">Change Picture</a>
                        <a href="#" class="btn btn-danger disabled">Delete Picture</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">Profile</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="d-flex flex-column">
                            <p class="my-1">Teacher ID </p>
                            <p class="my-1">Name </p>
                            <p class="my-1">Username </p>
                            <p class="my-1">Email Address </p>
                            <p class="my-1">Access Level </p>
                            <p class="my-1">Join at </p>
                        </div>
                        <div class="d-flex flex-column ml-2">
                            <p class="my-1">: {{ $user['id'] }}</p>
                            <p class="my-1">: {{ $user['name'] }}</p>
                            <p class="my-1">: {{ $user['username'] }}</p>
                            <p class="my-1">: {{ $user['email'] }}</p>
                            <p class="my-1">: {{ $user['role'] }}</p>
                            <p class="my-1">: {{ toCarbon($user['created_at'])->toDayDateTimeString() }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary disabled">Change Password</a>
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#logoutModal">Logout</a>
                    <a href="{{ route('admin.teachers.edit', ['teacher' => $user['id']]) }}" class="btn btn-primary float-right">Edit</a>
                </div>
            </div>
        </div>
    </div>

@endsection
