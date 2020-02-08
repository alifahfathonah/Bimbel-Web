@extends('tryout.layouts.main')

@section('title', 'Course')

@section('content')

    <!-- Page Heading -->
    <div class="row">
        <h2 class="ml-3 text-gray-800">Course</h2>
    </div>

    <div class="row mb-5">
        <div class="col-6">
            <div class="card accordion" id="accordionExample">
                <div class="card accordion" id="accordionExample">
                    <div class="card-body p-0">
                        @foreach ($courses as $course)
                            <div class="border p-3 list-group-item-action" id="heading{{ $course->id }}" type="button"
                                data-toggle="collapse" data-target="#collapse{{ $course->id }}"
                                aria-expanded="true" aria-controls="collapse{{ $course->id }}">
                                <h5 class="text-primary mb-0"><b>{{ $course->title }}</b></h5>

                                @if (count($course->course_levels) > 0)
                                    <small class="text-success">{{ count($course->course_levels) }} Items</small>
                                @else
                                    <small class="text-danger">Empty</small>
                                @endif

                            </div>

                            <div id="collapse{{ $course->id }}" class="collapse" aria-labelledby="heading{{ $course->id }}" data-parent="#accordionExample">
                                <ul class="list-group list-group-flush">
                                    @foreach ($course->course_levels as $level)
                                        <li class="list-group-item list-group-item-action pl-5">
                                            <div class="row">
                                                <div class="col-10">

                                                    @if (count($level->course_sublevels) > 0)
                                                        <a href="{{ route('tryout.level.index', ['id'=>$level->id]) }}">
                                                            {{ $level->title }}
                                                        </a><br>
                                                    @else
                                                        <a href="#">{{ $level->title }}</a><br>
                                                    @endif

                                                    <small>{{ $course->title }}</small>
                                                </div>

                                                @if (count($level->course_sublevels) > 0)
                                                    <div class="col-2 py-3 text-success"><small>{{ count($level->course_sublevels) }} Items</small></div>
                                                @else
                                                    <div class="col-2 py-3 text-danger"><small>Empty</small></div>
                                                @endif

                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
