@extends('tryout.layouts.app')

@section('title', 'Student Login')

@section('app')

<div class="container-fluid bg-primary" style="min-height: 100vh">

    <div class="row justify-content-center mt-4">
        <div class="col-md-4">
            <img class="img-fluid" src="{{ asset('img/logo.png') }}">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="p-4 p-md-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-3">Student Login</h1>
                                </div>

                                <hr class="my-3 my-md-4">

                                <form class="user" method="POST" action="{{ route('tryout.login.post') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control p-4 @error('username') is-invalid @enderror"
                                            name="username" placeholder="Username" value="{{ old('username') }}"
                                            @if ($errors->has('username') || !$errors->has('password')) autofocus @endif>
                                        @error('username')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control p-4 @error('password') is-invalid @enderror"
                                            name="password" placeholder="Password" @error('password') autofocus @enderror>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block p-3 text-lg mt-3 mt-md-4">
                                        <i class="fas fa-sign-in-alt"></i>
                                        <strong>Login</strong>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
