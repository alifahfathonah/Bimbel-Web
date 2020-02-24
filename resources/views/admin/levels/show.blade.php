@extends('admin.layouts.app')

@section('title', 'Exams')

@section('content')

<!-- Page Heading -->
<div class="row">
    <h2 class="ml-3 mb-0 text-gray-800">@yield('title')</h2>
</div>
<hr class="mt-1 mb-4">

@if (session('status'))
@component('components.alert', ['type' => 'success'])
    {{ session('message') }}
@endcomponent
@endif

@if(session('errors'))
@component('components.alert', ['type' => 'danger'])
{{ session('errors')->first() }}
@endcomponent
@endisset

<div class="row align-items-start">
    @component('components.custom_card', ['type' => 'danger', 'class' => 'col-md-6'])
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center">
                <div class="text-xl font-weight-bold text-danger text-uppercase mb-1">
                    {{ $level['title'] }}
                    <small class="d-block text-capitalize text-secondary">{{ $course['title'] }}</small>
                </div>
                <a href="{{ route('admin.exams.sublevel.create', ['level_id'=>$level['id']]) }}" class="btn btn-outline-danger float-right">
                    <i class="fas fa-plus mr-2"></i> New
                </a>
            </div>
            <hr>

            @foreach ($sublevels as $sublevel)

                <button class="btn btn-outline-danger w-100 my-2 p-3 text-left shadow-sm" id="heading{{ $loop->index }}"
                        type="button" data-toggle="collapse" data-target="#collapse{{ $loop->index }}" aria-expanded="true"
                        aria-controls="collapse{{ $loop->index }}">
                    {{ $sublevel['title'] }}
                </button>

            @endforeach

        </div>
    @endcomponent

    <div class="accordion col-md-6" id="accordions">
        @foreach ($sublevels as $sublevel)

        <div id="collapse{{ $loop->index }}" class="collapse w-100" aria-labelledby="heading{{ $loop->index }}" data-parent="#accordions">

            @component('components.custom_card', ['type' => 'danger', 'class' => 'w-100'])

            <div class="col">

                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-xl font-weight-bold text-danger text-uppercase mb-1">
                        {{ $sublevel['title'] }}
                        <small class="d-block text-capitalize text-secondary">{{ $course['title'] }}</small>
                    </div>
                    <div>
                        <a href="{{ route('admin.exams.sublevel.edit', ['level_id' => $sublevel['course_level_id'], 'sublevel_id' => $sublevel['id']]) }}"
                            class="btn btn-outline-primary mr-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.sublevels.destroy', ['sublevel'=>$sublevel['id']]) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-auto">
                        Title <br>
                        Course <br>
                        Time <br>
                        Minimum Score <br>
                        Created at <br>
                    </div>
                    <div class="col">
                        : {{ $sublevel['title'] }} <br>
                        : {{ $course['title'] }} - {{ $level['title'] }} <br>
                        : {{ $sublevel['time'] }} Minutes<br>
                        : {{ $sublevel['minimum_score'] }}<br>
                        : {{ toCarbon($sublevel['created_at'])->toDayDateTimeString() }}<br>
                    </div>
                </div>

                @isset($sublevel['description'])
                <hr>
                <p class="m-0">{{ $sublevel['description'] }}</p>
                @endisset

                <hr>
                <a href="#" class="btn btn-success float-right disabled">View Exam</a>
                <a href="{{ route('admin.exams.sublevel.questions', ['sublevel_id'=>$sublevel['id'], 'level_id' => $sublevel['course_level_id']]) }}"
                    class="btn btn-success float-right mr-3">Manage Question</a>

            </div>

            @endcomponent

        </div>

        @endforeach

    </div>


</div>

@endsection

@push('js')
    <script>
        $('.collapse').on('show.bs.collapse', function () {
            $("html, body").animate({ scrollTop: 0 }, "slow")
        })
    </script>
@endpush
