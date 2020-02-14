@extends('admin.layouts.app')

@section('title', 'Exams')

@section('content')

<!-- Page Heading -->
<div class="row">
    <h2 class="ml-3 mb-0 text-gray-800">@yield('title')</h2>
</div>
<hr class="mt-1 mb-4">

@if (session('status'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

@if(session('errors'))
    @component('components.alert', ['type' => 'danger'])
        {{ session('errors')->first() }}
    @endcomponent
@endisset

<div class="row mb-5 align-items-start accordion" id="accordionExample">

    @component('components.custom_card', [
        'type' => 'info',
        'class' => 'col-md-6',
    ])
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                    Courses
                </div>
                <button class="btn btn-outline-info float-right" data-toggle="modal" data-target="#createModal" data-type="Course">
                    <i class="fas fa-plus mr-2"></i> New
                </button>
            </div>
            <hr>

            <div>
                @foreach ($courses as $course)
                <div class="btn-group my-2 w-100 shadow-sm" role="group">
                    <div class="btn btn-outline-info w-100 p-3" id="heading{{ $loop->index }}" type="button"
                        data-toggle="collapse" data-target="#collapse{{ $loop->index }}" aria-expanded="true"
                        aria-controls="collapse{{ $loop->index }}">
                            <h5 class="d-inline mb-0 float-left">{{ $course->title }}</h5>
                            <span class="float-right">{{ count($course->course_levels) }} Items</span>
                    </div>
                    <button class="btn btn-outline-info d-flex align-items-center" title="Edit" data-toggle="modal" data-target="#createModal"
                            data-title="{{ $course->title }}" data-id="{{ $course->id }}" data-type="Course">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-danger d-flex align-items-center" title="Delete"
                            onclick="delete_course({{ $course->id }})">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    @endcomponent

    @foreach ($courses as $course)
        <div id="collapse{{ $loop->index }}" class="collapse col-md-6" aria-labelledby="heading{{ $loop->index }}"
            data-parent="#accordionExample">

            @component('components.custom_card', [
            'type' => 'success',
            'class' => 'col-12',
            ])

            <div class="col-12">

                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                        Levels
                        <small id="course-label" class="d-block text-capitalize text-secondary">{{ $course->title }}</small>
                    </div>
                    <button id="btn-new-levels" class="btn btn-outline-success float-right" data-toggle="modal" data-course-id="{{ $course->id }}"
                        data-target="#createModal" data-type="Level">
                        <i class="fas fa-plus mr-2"></i> New
                    </button>
                </div>
                <hr>

                @forelse ($course->course_levels as $level)

                <div class="btn-group my-2 w-100 shadow-sm" role="group">
                    <a href="{{ route('admin.levels.show', ['level'=>$level->id]) }}" class="btn btn-outline-success w-100 p-3">

                        <span class="d-inline float-left"> {{ $level->title }}</span>

                        @if (count($level->course_sublevels) > 0)
                        <span class="d-inline float-right">{{ count($level->course_sublevels) }} Items</span>
                        @else
                        <span class="d-inline float-right">Empty</span>
                        @endif
                    </a>
                    <button class="btn btn-outline-success d-flex align-items-center" title="Edit" data-toggle="modal"
                        data-target="#createModal" data-title="{{ $level->title }}" data-id="{{ $level->id }}" data-type="Level">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-danger d-flex align-items-center" title="Delete" onclick="delete_level({{ $level->id }})">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>

                @empty
                <div class="text-center my-3">Empty</div>
                @endforelse

            </div>
            @endcomponent
        </div>
    @endforeach
</div>

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="form-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="course_id" value="" disabled>
                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label text-right">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" autofocus>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@push('js')
    <script>
        var url_new_course = "{{ route('admin.courses.store') }}"
        var url_edit_course = "{{ url('admin/courses') }}"

        var url_new_level = "{{ route('admin.levels.store') }}"
        var url_edit_level = "{{ url('admin/levels') }}"

        $('#createModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var type = button.data('type')
            var id = button.data('id')
            var title = ''

            $(this).find("input[name='course_id']").prop('disabled', true)
            $(this).find("input[name='course_id']").val('')

            if (id == null || id == undefined){
                $(this).find('.modal-title').text('New ' + type)
                $(this).find("input[name='_method']").prop('disabled', true)

                if (type == 'Level'){
                    $('#form-modal').attr('action', url_new_level)
                    $(this).find("input[name='course_id']").prop('disabled', false)
                    $(this).find("input[name='course_id']").val(button.data('course-id'))
                } else {
                    $('#form-modal').attr('action', url_new_course)
                }

            } else {
                $(this).find('.modal-title').text('Edit ' + type)
                $(this).find("input[name='_method']").prop('disabled', false)

                title = button.data('title')

                if (type == 'Level')
                    $('#form-modal').attr('action', url_edit_level + '/' + id)
                else
                    $('#form-modal').attr('action', url_edit_course + '/' +id)
            }

            $(this).find('.modal-body label').text(type + ' Title')

            $(this).find('#title').val(title)
            $(this).find('#title').attr('placeholder', type + ' Title')
            $(this).find('#title').trigger('focus')
        })

        function delete_course(id)
        {
            var url = url_edit_course + '/' + id
            post_link(url)
        }
        function delete_level(id)
        {
            var url = url_edit_level + '/' + id
            post_link(url);
        }
        function post_link(url){
            $('#post_form').attr('action', url)
            $('#post_form').submit()
        }
    </script>

<form id="post_form" action="" method="POST"> @csrf @method('DELETE') </form>
@endpush
