<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container-fluid" style="min-height: 100vh;">

        <div class="row justify-content-center my-5">
            <div class="col-4">
                <img class="img-fluid" src="{{ asset('img/logo.jpg') }}" alt="Logo">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    {{-- Header --}}
                    <div class="card-header">{{ __('Login') }}</div>

                    {{-- Login Form --}}
                    <div class="card-body">
                        <form method="POST" action="{{ route('tryout.post_login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="username" class="col-md-3 col-form-label text-md-right">{{ __('Username') }}</label>

                                <div class="col-md-9">
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>

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
                                <div class="col-md-8 offset-md-3">
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
</body>
</html>
