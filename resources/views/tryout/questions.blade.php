@extends('tryout.layouts.app')

@section('title', 'Dashboard')

@section('wrapper-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-1">
            <div class="card mt-3" style="height: 90vh">
                <div class="card-header px-2 text-center">Number</div>
                <div class="card-body p-0 overflow-auto">
                    <div class="list-group list-group-flush" style="height:100%; overflow: auto">
                        @foreach ($question_numbers as $number)

                        <a href="{{ route('tryout.exam', ['report_id'=>$report_id, 'number' => $number['number']]) }}"
                            class="list-group-item list-group-item-action text-center p-2
                            {{ isset($number->marked) ? 'list-group-item-warning' : '' }}
                            {{ ($number['number'] == $current_number) ? 'active' : '' }}">
                            {{ $number['number'] }}
                        </a>

                        @endforeach
                        <hr class="m-0">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-11">
            <div class="card mt-3" style="height: 90vh">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">
                            <h4>{{ $sublevel['title'] }}</h4>
                            <small>{{ $course_title }}</small>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-end">
                            <div class="d-flex flex-column align-items-center">
                                <b>{{ $remaining_time->format('H:i:s')}}</b>
                                <hr class="my-1 w-100">
                                <small>26/{{ $question_numbers->count() }}</small>
                            </div>
                            <form action="{{ route('tryout.exam.submit', ['report_id' => $report_id]) }}" method="post">
                                @csrf
                                <button type="submit" name="submit" class="ml-3 btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p>
                        {{ $question['question'] }}
                    </p>
                    @foreach ($question['answers'] as $answer)

                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="choice" id="choice{{ $answer['answer_order'] }}">
                            <label for="choice{{ $answer['answer_order'] }}" class="custom-control-label">{{ $answer['answer'] }}</label>
                        </div>

                    @endforeach
                </div>

                <div class="card-footer">
                    <a href="{{ route('tryout.exam', ['report_id'=>$report_id, 'number' => ($current_number + 1)]) }}"
                        class="btn btn-primary float-right ml-3 {{ $next_available }}">Next</a>

                    <a href="{{ route('tryout.exam.mark', ['report_id'=>$report_id, 'mark_number' => $current_number])}}" class="btn btn-warning float-right ml-3">Mark</a>

                    <a href="{{ route('tryout.exam', ['report_id'=>$report_id, 'number' => ($current_number - 1)]) }}"
                        class="btn btn-primary float-left {{ $prev_available}}">Previous</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        function show_question(number){
            var url = "{{ url('tryout/start') }}";
            var sublevel_id = "{{ $sublevel['id'] }}";
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    sublevel_id: sublevel_id,
                    current_number: number,
                    _token: token
                },
                success: function(result){
                    console.log(result.data);
                }
            });
        }
    </script>
@endsection
