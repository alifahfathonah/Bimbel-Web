@extends('tryout.layouts.main')

@section('title', 'Dashboard')

@section('content')

    <!-- Page Heading -->
    <div class="row">
        <h2 class="ml-3 text-gray-800">Course</h2>
    </div>

    <div class="row">
        <div class="col-4">
            <ul class="list-group">

                @foreach ($sublevels as $sublevel)
                <a class="list-group-item list-group-item-action" href="#" data-toggle="collapse"
                    data-target="#sublevel{{ $sublevel->id }}" aria-expanded="true" aria-controls="sublevel{{ $sublevel->id }}">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <h5 class="m-0">
                            {{ $sublevel->title }}
                            @if (isset($sublevel->status) && $sublevel->status == 1)
                                <div class="m-0 d-inline badge">
                                    <small class="badge badge-pill badge-warning">Running</small>
                                </div>
                            @endif

                        </h5>


                        @if (isset($sublevel->status) && $sublevel->status == 2)
                            @if ($sublevel->score >= $sublevel->minimum_score)
                                <h6 class="m-0 text-success">
                                    <b>{{ $sublevel->score }}/100 ({{ getScoreGrade($sublevel->score) }})</b>
                                </h6>
                            @else
                                <h6 class="m-0 text-danger"><b>{{ $sublevel->score }}/100 ({{ getScoreGrade($sublevel->score) }})</b></h6>
                            @endif
                        @else
                            <h6 class="m-0"><b>~/100</b></h6>
                        @endif

                    </div>
                </a>

                @endforeach

            </ul>
        </div>

        <div class="col-8">
            <div class="accordion" id="SublevelAccordion">
                @foreach ($sublevels as $sublevel)

                <div id="sublevel{{ $sublevel->id }}" class="collapse {{ ($loop->iteration == 1) ? 'show' : '' }}" data-parent="#SublevelAccordion">
                    <div class="card shadow" style="min-height: 50vh">
                        <div class="card-header">
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <h5 class="m-0">{{ $sublevel->title }}</h5>
                                @if (isset($sublevel->status) && $sublevel->status == 2)
                                    @if ($sublevel->score >= $sublevel->minimum_score)
                                        <h6 class="m-0 text-success">
                                            <b>{{ $sublevel->score }}/100 ({{ getScoreGrade($sublevel->score) }})</b>
                                        </h6>
                                    @else
                                        <h6 class="m-0 text-danger"><b>{{ $sublevel->score }}/100 ({{ getScoreGrade($sublevel->score) }})</b></h6>
                                    @endif
                                @else
                                    <h6 class="m-0"><b>~/100</b></h6>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between align-items-top">
                                @if (isset($sublevel->status) && $sublevel->status == 2)
                                    <div class="d-flex flex-column justify-content-start">
                                        <small>Score :
                                            <span class="{{ ($sublevel->score >= $sublevel->minimum_score) ? 'text-success' : 'text-danger' }}">
                                                {{ $sublevel->score }} ({{ getScoreGrade($sublevel->score) }})
                                            </span>
                                        </small>
                                        <small>Start Time : {{ toCarbon($sublevel->created_at)->toDayDateTimeString() }}</small>
                                        <small>Finish Time : {{ toCarbon($sublevel->finish_time)->toDayDateTimeString() }}</small>
                                        <small>Time Spent : {{ getTimeSpent($sublevel->created_at, $sublevel->finish_time)->format('H:i:s') }}</small>
                                    </div>
                                @endif
                                <div class="d-flex flex-column justify-content-start">
                                    <small>Minimum Score : {{ $sublevel->minimum_score }}</small>
                                    <small>Time : {{ $sublevel->time }} Minutes</small>
                                </div>
                            </div>
                            <hr>
                            <p class="card-text">{{ $sublevel->descrption }}</p>
                        </div>
                        <div class="card-footer">
                            @if (isset($sublevel->status) && $sublevel->status > 0 && $sublevel->status < 3)
                                @if ($sublevel->status == 2)
                                    <button class="btn btn-success float-right" disabled>
                                        View Result
                                    </button>
                                @elseif ($sublevel->status == 1)
                                    <a href="{{ route('tryout.exam', ['report_id' => $sublevel->report_id, 'number' => 1]) }}" class="btn btn-warning float-right">
                                        Continue
                                    </a>
                                @endif
                            @else
                                <form action="{{ route('tryout.exam.start') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="sublevel_id" value="{{ $sublevel->id }}">
                                    <button type="submit" class="btn btn-primary float-right">
                                        Start
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>

    </div>

@endsection
