@extends('tryout.layouts.app')

@section('title', 'Dashboard')

@section('content')

    @if(session('status') || session('errors'))
        @component('components.alert', ['type' => session('status') ? 'success':'danger'])
            @if(session('status'))
                {{ session('message') }}
            @else
                {{ session('errors')->first() }}
            @endif
        @endcomponent
    @endisset

    <!-- Page Heading -->
    <div class="row">
        <h2 class="ml-3 text-gray-800">Profile</h2>
    </div>
    <hr class="mt-0">

    <div class="row align-items-start">

        @component('components.card_border_left', [
            'type' => 'primary',
            'class' => 'col-md-6 col-12',
            ])

            @slot('header')
            <h5 class="m-0 text-primary">User Profile</h5>
            @endslot

            <form action="{{ route('tryout.profile.edit_profile') }}" method="post">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="Name">Name</label>
                    <input id="Name" class="form-control" type="text" name="name" placeholder="Name" disabled value="{{ $user['name'] }}">
                </div>
                <div class="form-group">
                    <label for="Username">Username</label>
                    <input id="Username" class="form-control" type="text" name="username" placeholder="Username" disabled value="{{ $user['username'] }}">
                </div>

                <div class="custom-control custom-switch">
                    <input id="password_enable" class="custom-control-input" type="checkbox" name="password_enable" {{ $user['password_enable'] == 1 ? 'checked':'' }}>
                    <label for="password_enable" class="custom-control-label">Use password to login</label>
                </div>
                <small class="text-danger" id="passwordWarning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    If turned off everyone can login to your account with empty password
                </small>
                <hr>
                <p>Join at {{ toCarbon($user['created_at'])->isoFormat('dddd, D MMMM Y hh:mm:ss') }}</p>

                <hr>
                <a href="#" class="btn btn-primary d-none">Change Password</a>
                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#logoutModal">Logout</a>
                <a href="#" class="btn btn-primary float-right d-none">Edit</a>
                <button type="submit" class="btn btn-primary float-right px-3">Save</button>

            </form>


        @endcomponent

        @component('components.card_border_left', [
            'type' => 'primary',
            'class' => 'col-md-6 col-12'
        ])

            <h5 class="m-0 text-primary">Change Password</h5>
            <hr>

            <form action="{{ route('tryout.profile.change_password') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="oldPassword">Old Password</label>
                    <input id="oldPassword" class="form-control @error('old_password') is-invalid @enderror"
                           type="password" name="old_password" placeholder="Old Password">

                    @error('old_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input id="newPassword" class="form-control @error('new_password') is-invalid @enderror"
                           type="password" name="new_password" placeholder="New Password">

                    @error('new_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="passwordConfirmation ">Confirm Password</label>
                    <input id="passwordConfirmation " class="form-control @error('new_password_confirmation') is-invalid @enderror"
                           type="password" name="new_password_confirmation" placeholder="Confirm Password">

                    @error('new_password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <hr>
                <button type="submit" class="btn btn-primary px-3 float-right">Save</button>

            </form>

        @endcomponent

    </div>
@endsection

@push('js')
<script>

    function toggle_warning(){
        console.log('check fired');
        if ($('#password_enable').prop('checked')){
            console.log('checked');
            $('#passwordWarning').hide();
        } else {
            console.log('unchecked');
            $('#passwordWarning').show();
        }
    }
    toggle_warning();
    $('#password_enable').change(toggle_warning)
</script>
@endpush
