@extends('admin.layouts.app')

@section('title', 'Students')

@section('content')
<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center my-3">
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">New Student</a>
</div>

@if (session('status'))
    <div class="alert alert-success">
    {{ session('message') }}
    </div>
@endif

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Students List</h6>
    </div>
    <div class="card-body">

        @component('components.table', [
            'colums' => [ 'Username', 'Name', 'Password Enable', 'Join At', 'Action',]
        ])
            @foreach ($students as $student)
            <tr>
                <td>{{ $student['username'] }}</td>
                <td>{{ $student['name'] }}</td>
                <td>{{ $student['password_enable'] == 1 ? 'Yes' : 'No' }}</td>
                <td>{{ toCarbon($student['created_at'])->format('d M Y H:i') }}</td>
                <td>
                    <div class="d-flex flex-row justify-content-center align-content-center">
                        <a href="{{ route('admin.students.show', ['student' => $student['id']]) }}"
                            class="btn btn-primary btn-circle btn-sm mx-1" data-toggle="tooltip" data-placement="bottom" title="Details">
                            <i class="fas fa-info"></i>
                        </a>
                        <a href="{{ route('admin.students.edit', ['student' => $student['id']]) }}"
                            class="btn btn-primary btn-circle btn-sm mx-1" data-toggle="tooltip" data-placement="bottom"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.students.destroy', ['student' => $student['id']]) }}" method="post" class="mx-1">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-circle btn-sm" data-toggle="tooltip"
                                data-placement="bottom" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach

        @endcomponent

    </div>
</div>
@endsection


@section('js')
    <script>
        alert(jsbdakbdiuwa);
    </script>
@endsection

