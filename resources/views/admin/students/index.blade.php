@extends('admin.layouts.main')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="row justify-content-between align-items-center">
        <h2 class="ml-3 text-gray-800">Students</h2>
        <a href="{{ route('admin.student.create') }}" class="btn btn-primary">+ Add New Student</a>
        <button class="btn btn-primary" onclick="new_student()">New Student</button>
    </div>
    @if (session('status'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        </div>
    </div>
    @endif
    <div class="row mt-3">
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th style="width: 5%">ID</th>
                    <th style="width: 20%">Name</th>
                    <th style="width: 10%">Username</th>
                    <th style="width: 12%">Password Enable</th>
                    <th style="width: 15%">Join At</th>
                    <th style="width: 7%">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td class="text-center align-middle">{{ $student['id'] }}</td>
                        <td>{{ $student['name'] }}</td>
                        <td>{{ $student['username'] }}</td>
                        <td>{{ $student['password_enable'] == 1 ? 'Yes' : 'No' }}</td>
                        <td>{{ toCarbon($student['create_at'])->toDayDateTimeString() }}</td>
                        <td>
                            <a href="#" class="btn btn-primary" onclick="edit_student({{ $student['id'] }})" data-toggle="tooltip" data-placement="bottom" title="Edit Student">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.student.destroy', ['id' => $student['id']]) }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Student">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentLabel">Modify</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" role="alert" id="alert"></div>
                    <form action="" method="post" id="student_form">
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input id="id" class="form-control read" type="text" name="id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" class="form-control" type="text" name="username">
                            <div class="invalid-feedback" id="usernameError"></div>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control" type="text" name="name" required>
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="password_enable" name="password_enable">
                            <label class="custom-control-label" for="password_enable">Enable Password</label>
                        </div>

                        <p class="my-2" id="join_at"></p>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mr-auto">Reset Password</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_save">Save changes</button>
                </div>
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
        $(document).ready( function () {
            $('#dataTable').DataTable();
        } );

        var generate_id_url = "{{ route('admin.student.generate') }}";
        var get_user_url = "{{ route('admin.student.edit', ['id' => 1]) }}";
        var new_url = "{{ route('admin.student.store') }}";
        var edit_url = "{{ route('admin.student.edit.post') }}";

        function get_data(){

            var id = $('#id').val();
            var name = $('#name').val();
            var username = $('#username').val();
            var password_enable = $('#password_enable').prop('checked');
            var _token = "{{ csrf_token() }}";

            return {
                _token: _token,
                id: id,
                name: name,
                username: username,
                password_enable: password_enable,
            }
        }

        function show_alert(message){
            $('#alert').text(message);
            $('#alert').show();
        }

        function add_student(){
            $('#alert').hide();
            $.ajax({
                url: new_url,
                type: 'post',
                data: get_data(),
                success:
                function(response){
                    if (response.status == 'success'){
                        show_alert(response.message);
                    }
                },
                error: function(error){
                    console.log(error);
                    show_error(error.responseJSON.errors);
                }
            });
        }

        function show_error(error){
            if (error.username != null){
                $('#usernameError').text(error.username);
                $('#username').addClass('is-invalid');
            }
            if (error.name != null){
                $('#nameError').text(error.name);
                $('#name').addClass('is-invalid');
            }
        }

        function update_student(){
            $('#alert').hide();
            $.ajax({
                url: edit_url,
                type: 'post',
                data: get_data(),
                success:
                function(response){
                    if (response.status == 'success'){
                        show_alert(response.message);
                    }
                }
            });
        }

        function new_student(){
            hide_form();

            $.ajax({
                url: generate_id_url,
                type: 'get',
                success:
                function(response)
                {
                    $('#id').val(response.id);
                    show_form();
                    $('#btn_save').click(add_student);
                }
            });
            reset_form();
            $('#studentModal').modal('show');
        }

        function edit_student(id){
            $('#student_form').attr('action', edit_url);
            hide_form();
            $.ajax({
                url: edit_url,
                type: 'get',
                data: {
                    id: id
                },
                success:
                function(response)
                {
                    $('#id').val(response.id);
                    $('#name').val(response.name);
                    $('#username').val(response.username);
                    $('#password_enable').prop('checked', (response.password_enable == 1));
                    $('#join_at').text('Join at ' + response.join);
                    show_form();
                    $('#btn_save').click(update_student);
                }
            });
            reset_form();
            $('#studentModal').modal('show');
        }

        function show_form(){
            $('#student_form').show();
        }

        function hide_form(){
            $('#student_form').hide();
        }

        function reset_form(){
            $('.is-invalid').removeClass('is-invalid');
            $('#alert').hide();
            $('#id').val('');
            $('#name').val('');
            $('#username').val('');
            $('#join_at').text('');
            $('#btn_save').unbind();
        }

    </script>
@endsection

