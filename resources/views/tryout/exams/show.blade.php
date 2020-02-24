@extends('tryout.layouts.app')

@section('title', 'Exams')

@section('content')

<!-- Page Heading -->
<div class="row">
    <h2 class="ml-3 mb-0 text-gray-800">@yield('title')</h2>
</div>
<hr class="mt-1 mb-4">

<div class="row align-items-start">
    @component('components.card_border_left', ['type' => 'primary'])

        @slot('header')
            {{ $level['title'] }}
            <small class="d-block text-capitalize text-secondary">{{ $course['title'] }}</small>
        @endslot

        @foreach ($sublevels as $sublevel)

        <button class="btn btn-outline-primary text-left btn-block my-2 p-3 shadow-sm" id="heading{{ $loop->index }}"
            type="button" data-toggle="collapse" data-target="#collapse{{ $loop->index }}" aria-expanded="true"
            aria-controls="collapse{{ $loop->index }}">{{ $sublevel['title'] }}
            @if ($sublevel['status'] == 2)
            <b class="float-right text-{{ $sublevel['is_above_min'] ? 'success' : 'danger' }}">
                {{ $sublevel['score'] }}/100 ({{ getScoreGrade($sublevel['score']) }})
            </b>
            @elseif($sublevel['status'] == 1)
                <span class="badge badge-warning badge-pill float-right py-2 px-3">Running</span>
            @else
                {{-- <b class="float-right">{{ $sublevel['score'] }}/100</b> --}}
            @endif
        </button>

        @endforeach
    @endcomponent

    <div class="accordion col-md-6" id="accordions">

        @foreach ($sublevels as $sublevel)

        <div id="collapse{{ $loop->index }}" class="collapse w-100" aria-labelledby="heading{{ $loop->index }}"
            data-parent="#accordions">
            @component('components.card_border_left', ['type' => $sublevel['type'], 'class' => 'col-12 p-0'])

            @slot('header')
            <div class="d-flex align-items-center">
                <div class="flex-fill text-{{ $sublevel['type'] }}">
                    <b>{{ $sublevel['title'] }}</b>
                    <p class="mb-0 text-capitalize text-secondary">
                        {{ $course['title'] }} - {{ $level['title'] }}
                    </p>
                </div>

                @switch($sublevel['status'])
                    @case(1)
                        <span class="badge badge-warning badge-pill py-2 px-3">Running</span>
                        @break
                    @case(2)
                        <b class="text-{{ $sublevel['is_above_min'] ? 'success' : 'danger' }}">
                            {{ $sublevel['score'] }}/100 ({{ getScoreGrade($sublevel['score']) }})
                        </b>
                        @break
                    @default
                        <b>{{ $sublevel['score'] }}/100</b>
                @endswitch
            </div>
            @endslot

            <!-- Detais -->
            <b>Details</b>
            <div class="row">
                <div class="col-4">
                    Time <br>
                    Minimum Score <br>
                    Question Type <br>
                </div>
                <div class="col-6">
                    : {{ $sublevel['time'] }} Minutes<br>
                    : {{ $sublevel['minimum_score'] }}<br>
                    : Multiple Choices<br>
                </div>
            </div>

            <!-- Result -->
            @if ($sublevel['status'] == 2)
            <hr>
            <b>Result</b>
            <div class="row">
                <div class="col-4">
                    Score <br>
                    Start Time <br>
                    Finish Time <br>
                    Time Spent <br>
                </div>
                <div class="col-6">
                    : <span class="text-{{ $sublevel['type'] }}">
                        {{ $sublevel['score'] }} ({{ getScoreGrade($sublevel['score']) }})
                    </span><br>
                    : {{ toCarbon($sublevel['reports'][0]['created_at'])->toDayDateTimeString() }}  <br>
                    : {{ toCarbon($sublevel['reports'][0]['finish_time'])->toDayDateTimeString() }} <br>
                    : {{ getTimeSpent($sublevel['reports'][0]['created_at'], $sublevel['reports'][0]['finish_time'])->format('H:i:s') }} <br>
                </div>
            </div>
            @endif

            <!-- Descriptions -->
            <hr>
            <div class="row">
                <div class="col-12">
                    <b>Description</b>
                    <p>{{ $sublevel['description'] }}</p>
                </div>
            </div>

            <!-- Buttons -->
            @slot('footer')
            @switch($sublevel['status'])
                @case(1)
                    <button class="btn btn-warning float-right ml-3 disabled">Continue</button>
                    @break
                @case(2)
                    @if ($sublevel['is_above_min'])
                        <button class="btn btn-success float-right ml-3 disabled">View Result</button>
                    @else
                        <button class="btn btn-danger float-right ml-3 disabled">Retake Exam</button>
                    @endif
                    @break
                @default
                    <form action="{{ route('tryout.exams.start', ['level_id' => $level['id'], 'sublevel_id' => $sublevel['id']]) }}" method="post">
                        @csrf
                        <input type="hidden" name="sublevel_id" value="{{ $sublevel['id'] }}">
                        <button class="btn btn-primary float-right ml-3" type="submit">Start Exam</button>
                    </form>

            @endswitch
            @endslot

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
