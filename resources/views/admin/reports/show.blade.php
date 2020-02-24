@extends('admin.layouts.app')

@section('title', 'Reports Details')

@section('content')
<!-- Page Heading -->
<div class="d-flex flex-row justify-content-between align-items-center my-3">
    <h1 class="h3 mb-2 text-gray-800">@yield('title')</h1>
</div>


<div class="d-flex flex-row justify-content-end align-items-start">
    @component('components.custom_card', [
        'type' => 'warning',
        'class' => 'col-6'
        ])

    <div class="col">
        <h5 class="m-0">Report Details</h5>
        <hr>

        <div class="d-flex flex-row">
            <div class="d-flex flex-column">
                <p class="m-0">Student Name</p>
                <p class="m-0">Course</p>
                <p class="m-0">Level</p>
                <p class="m-0">Score</p>
                <p class="m-0">Minimum Score</p>
                <p class="m-0">Exam Time</p>
                <p class="m-0">Start Time</p>
                <p class="m-0">Finish Time</p>
                <p class="m-0">Time Spent</p>
                <p class="m-0">Status</p>
            </div>
            <div class="d-flex flex-column mx-3">
                <p class="m-0">: {{ Arr::get($report, 'student.name')}} </p>
                <p class="m-0">: {{ Arr::get($report, 'sublevel.level.course.title') }} </p>
                <p class="m-0">: {{
                    Arr::get($report, 'sublevel.level.title') .
                    ' - ' .
                    Arr::get($report, 'sublevel.title')
                }}
                </p>
                <p class="m-0">:
                    @if (Arr::get($report, 'score') >= Arr::get($report, 'sublevel.minimum_score'))
                    <b class="text-success">
                    @else
                    <b class="text-danger">
                    @endif
                        {{ Arr::get($report, 'score') }}
                        ({{ getScoreGrade(Arr::get($report, 'score'))}})
                    </b>
                </p>
                <p class="m-0">: {{ Arr::get($report, 'sublevel.minimum_score') }} </p>
                <p class="m-0">: {{ Arr::get($report, 'sublevel.time') }} Minutes</p>
                <p class="m-0">: {{
                    toCarbon(Arr::get($report, 'created_at'))
                        ->isoFormat('dddd, D MMMM YYYY  HH:mm:ss')
                }}

                </p>
                @if ($report['status'] == 2)
                <p class="m-0">: {{
                    toCarbon(Arr::get($report, 'finish_time'))
                        ->isoFormat('dddd, D MMMM YYYY  HH:mm:ss')
                }}
                </p>

                <p class="m-0">: {{
                    toTimeStringFormat(getTimeSpent(
                        Arr::get($report, 'created_at'),
                        Arr::get($report, 'finish_time')
                    )) }}
                </p>
                <p class="m-0">:
                    <b class="text-success">Done</b>
                </p>
                @else
                <p class="m-0">-</p>
                <p class="m-0">-</p>
                <p class="m-0">
                    <b class="text-warning">Still Running</b>
                </p>
                @endif

            </div>
        </div>

        <hr>

        <div class="d-flex flex-row mt-2">
            <a href="#" class="btn btn-primary mr-2 disabled">Level Details</a>
            <a href="#" class="btn btn-success mr-2 disabled">View Result</a>
        </div>

    </div>

    @endcomponent

    @include('admin.students.student_details', ['student' => $report['student']])

</div>

@endsection
