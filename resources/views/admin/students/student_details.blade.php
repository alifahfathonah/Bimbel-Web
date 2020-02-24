@component('components.custom_card',[
    'type' => 'success',
    'class' => $class ?? 'col-6',
])

<div class="col">
    <h5 class="m-0">Student Details</h5>
    <hr>
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
    <hr>
    <div>
        <a href="#" class="btn btn-warning mr-2 disabled">Reset Password</a>
        <a href="{{ route('admin.students.edit', ['student'=> $student['id']]) }}"
            class="btn btn-primary float-right">Edit</a>
        <form action="{{ route('admin.students.destroy', ['student' => $student['id']]) }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>


@endcomponent

