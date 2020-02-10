@extends('admin.layouts.app')

@section('title', 'Admin Login')

@section('wrapper-content')
<div class="container-fluid primary-bg height-min" style="min-height: 100vh; background: rgba(84, 33, 224, .7);">
    <div class="row justify-content-center my-4">
        <div class="col-md-2 pr-0">
            <img src="{{ asset('img/icon.png') }}" alt="Icon" class="img-fluid">
        </div>
        <div class="col-md-5 d-flex flex-column text-white justify-content-center pl-0 align-items-start">
            <h1 style="font-size: 8rem">Manggis</h1>
            <h3 style="background: rgba(0, 0, 0, .3); border-radius: 5rem" class="px-3 py-1">
                Matematika - Bahasa Inggris - Tahfidz
            </h3>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header text-gray-900">{{ __('Admin Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.login.post') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-3 col-form-label text-md-right text-gray-900">{{ __('Username') }}</label>

                            <div class="col-md-9">
                                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right text-gray-900">{{ __('Password') }}</label>

                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
