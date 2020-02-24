@extends('tryout.layouts.app')

@section('title', 'Exams')

@section('content')

<div class="row">
    <h2 class="ml-3 mb-0 text-gray-800">@yield('title')<h2>
</div>
<hr class="mb-4">

<div class="row align-items-start">
    @component('components.custom_card', ['type' => 'primary', 'class' => 'col-12 col-md-6 mb-4'])

    <div class="col">

        <div class="d-flex justify-content-between align-items-center">
            <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                Courses
            </div>
        </div>
        <hr>

        @foreach ($courses as $course)
            <button class="btn btn-outline-primary btn-block p-3 text-lg" data-toggle="collapse"
                    data-target="#collapse{{ $loop->index }}" aria-expanded="true" aria-controls="collapse{{ $loop->index }}">
                {{ $course['title'] }}
            </button>
        @endforeach


    </div>

    @endcomponent

    <div class="col-12 col-md-6">
        <div class="accordion" id="accordions">
        @foreach ($courses as $course)
                <div id="collapse{{ $loop->index }}" class="collapse col-12 p-0" aria-labelledby="heading{{ $loop->index }}"
                    data-parent="#accordions">

                    @component('components.custom_card', ['type' => 'info', 'class' => 'col-12 p-0'])
                        <div class="col p-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                                    <b>{{ $course->title }}</b>
                                </div>
                            </div>
                            <hr>

                            @foreach ($course->course_levels as $level)
                                <a href="{{ route('tryout.exams.show', ['level_id' => $level['id']]) }}"
                                    class="btn btn-outline-info p-3 my-2 shadow-sm btn-block">
                                    {{ $level->title }}
                                </a>
                            @endforeach

                        </div>
                    @endcomponent

                </div>
        @endforeach
        </div>
    </div>
</div>
@endsection
