@extends('admin.layouts.main')

@section('title', 'Dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-content-center my-3">
    <h1 class="h3 mb-2 text-gray-800">Students</h1>
    <a href="{{ route('admin.student.create') }}" class="btn btn-primary">New Student</a>
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
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Password Enable</th>
                        <th>Join At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Password Enable</th>
                        <th>Join At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student['username'] }}</td>
                            <td>{{ $student['name'] }}</td>
                            <td>{{ $student['password_enable'] == 1 ? 'Yes' : 'No' }}</td>
                            <td>{{ toCarbon($student['created_at'])->format('d M Y H:i') }}</td>
                            <td>
                                <div class="d-flex flex-row justify-content-center align-content-center">
                                    <a href="{{ route('admin.student.edit', ['id' => $student['id']]) }}" class="btn btn-primary btn-circle btn-sm mx-1" data-toggle="tooltip" data-placement="bottom" title="Edit Student">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.student.destroy', ['id' => $student['id']]) }}" method="post" class="mx-1">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-circle btn-sm" data-toggle="tooltip" data-placement="bottom" title="Delete Student">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        } );
    </script>
@endsection

