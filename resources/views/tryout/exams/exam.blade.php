@extends('tryout.layouts.app')

@section('title', 'Exams')

@section('app')

<div id="app" class="container-fluid">
    <exam-form
        exam-prepare-url="{{ route('tryout.exams.prepare', ['report_id' => $report['id']]) }}"
        exam-mark-question-url="{{ route('tryout.exams.mark', ['report_id' => $report['id']]) }}"
        exam-answer-url="{{ route('tryout.exams.answer', ['report_id' => $report['id']]) }}"
        exam-submit-url="{{ route('tryout.exams.submit') }}"
        exam-id="{{ $report['id'] }}"
        course-title="{{ $course->title }}"
        level-title="{{ $level->title }}"
        sublevel-title="{{ $sublevel->title }}"
        >
    </exam-form>
</div>

@endsection

@push('js')
<script src="{{ asset('js/app.js') }}"></script>
@endpush
