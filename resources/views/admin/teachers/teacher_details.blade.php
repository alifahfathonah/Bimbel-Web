@component('components.custom_card', [
    'type' => 'primary',
    'class' => 'col-6',
])
<div class="col">
    <h5 class="m-0">{{ $user['name'] }}</h5>
    <hr>
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
    <hr>
    <div>
        <a href="#" class="btn btn-warning mr-2 disabled">Reset Password</a>
        <a href="{{ route('admin.teachers.edit', ['teacher'=> $user['id']]) }}"
            class="btn btn-primary float-right px-4 disabled">Edit</a>
        <form action="{{ route('admin.teachers.destroy', ['teacher' => $user['id']]) }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>

</div>

@endcomponent
