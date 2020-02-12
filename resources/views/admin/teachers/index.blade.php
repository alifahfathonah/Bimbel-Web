@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center my-3">
    <h1 class="h3 mb-2 text-gray-800">Teachers</h1>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">New Teacher</a>
</div>

@if (session('status'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Teachers List</h6>
    </div>
    <div class="card-body">

        @component('components.table',[
            'colums' => ['ID','Username','Name','Email','Role','Join At','Action'],
        ])
            @foreach ($teachers as $teacher)
            <tr>
                <td>{{ $teacher['id'] }}</td>
                <td>{{ $teacher['name'] }}</td>
                <td>{{ $teacher['username'] }}</td>
                <td>{{ $teacher['email'] }}</td>
                <td>{{ $teacher['user_role']['name'] }}</td>
                <td>{{ toCarbon($teacher['created_at'])->toDayDateTimeString() }}</td>
                <td>
                    <div class="d-flex flex-row justify-content-center align-content-center">
                        <a href="{{ route('admin.teachers.show', ['teacher' => $teacher['id']]) }}"
                            class="btn btn-primary btn-circle btn-sm mx-1" data-toggle="tooltip" data-placement="bottom"
                            title="Details">
                            <i class="fas fa-info"></i>
                        </a>
                        <a href="{{ route('admin.teachers.edit', ['teacher' => $teacher['id']]) }}"
                            class="btn btn-primary btn-circle btn-sm mx-1" data-toggle="tooltip" data-placement="bottom"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.teachers.destroy', ['teacher' => $teacher['id']]) }}" method="post"
                            class="mx-1">
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
