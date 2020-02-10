@extends('tryout.layouts.main')

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
                            <p class="m-0">Name </p>
                            <p class="m-0">Username </p>
                            <p class="m-0">Join at </p>
                        </div>
                        <div class="d-flex flex-column ml-2">
                            <p class="m-0">: {{ $user['name'] }}</p>
                            <p class="m-0">: {{ $user['username'] }}</p>
                            <p class="m-0">: {{ toCarbon($user['created_at'])->toDayDateTimeString() }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary">Change Password</a>
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#logoutModal">Logout</a>
                    <a href="#" class="btn btn-primary float-right disabled">Edit</a>
                </div>
            </div>
        </div>
    </div>

@endsection
