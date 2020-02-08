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
                    data-target="#sublevel{{ $sublevel['id'] }}" aria-expanded="true" aria-controls="sublevel{{ $sublevel['id'] }}">
                    <div class="row">
                        <div class="col-10">
                            {{ $sublevel['title']}}
                        </div>
                        <div class="col-2">
                            <small class="">~/100</small>
                        </div>
                    </div>
                </a>

                @endforeach

            </ul>
        </div>

        <div class="col-8">
            <div class="accordion" id="SublevelAccordion">
                @foreach ($sublevels as $sublevel)


                <div id="sublevel{{ $sublevel['id'] }}" class="collapse @if ($loop->iteration == 1) show @endif" data-parent="#SublevelAccordion">
                    <div class="card" style="min-height: 50vh">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-11">
                                    <h5 class="m-0">{{ $sublevel['title'] }}</h5>
                                </div>
                                <div class="col">{{ $sublevel['minimum_score'] }}</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $sublevel['descrption'] }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary float-right">Start</a>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>

    </div>

@endsection
