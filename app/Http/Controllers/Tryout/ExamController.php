<?php

namespace App\Http\Controllers\Tryout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseSublevel;
use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\MarkedQuestion;
use App\Models\MultipleChoiceAnswer;
use App\Models\Question;
use App\Models\Report;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{

    public function start_exam(Request $request)
    {
        $this->validate($request, [
            'sublevel_id' => 'required|exists:course_sublevels,id',
        ]);

        $report = $this->_createReports($request['sublevel_id']);
        $sublevel = CourseSublevel::where('id', $request['sublevel_id'])->first();

        return redirect(route('tryout.exam', ['report_id' => $report->id, 'number' => 1]));
    }

    public function show_exam(Request $request)
    {
        $this->validate($request, [
            'report_id' => 'required|exists:reports,id',
        ]);

        $report_id = $request['report_id'];
        $report = Report::where('id', $report_id)->first();

        $sublevel_id = $report['course_sublevel_id'];
        $sublevel = CourseSublevel::where('id', $sublevel_id)->first();

        $this->validate($request, [
            'number' => [
                'required',
                Rule::exists('questions', 'number')
                    ->where(function ($query) use ($sublevel_id) {
                        $query->where('course_sublevel_id', $sublevel_id);
                    }),
            ]
        ]);

        return $this->_show_exam($report, $sublevel, $request['number']);
    }

    public function mark_question(Request $request)
    {
        $this->validate($request, [
            'report_id' => 'required|exists:reports,id',
        ]);

        $report = Report::where('id', $request['report_id'])->first();
        $sublevel_id = $report->course_sublevel_id;

        $this->validate($request, [
            'mark_number' => [
                'required',
                Rule::exists('questions', 'number')
                    ->where(function ($query) use ($sublevel_id) {
                        $query->where('course_sublevel_id', $sublevel_id);
                    }),
            ]
        ]);
        $mark = MarkedQuestion::where('report_id', $request['report_id'])
            ->where('number', $request['mark_number'])
            ->first();
        if (!$mark) {
            $mark = new MarkedQuestion;
            $mark->report_id = $report->id;
            $mark->number = $request['mark_number'];
            $mark->save();
        } else {
            $mark->delete();
        }

        return redirect()->back();
    }

    public function submit_exam(Request $request)
    {
        $this->validate($request, [
            'report_id' => 'required|exists:reports,id',
        ]);

        $report = Report::find($request['report_id']);

        if (!$report){
            return redirect()->back();
        } else {
            $sublevel = CourseSublevel::find($report->course_sublevel_id);
            $level = CourseLevel::find($sublevel->course_level_id);

            MarkedQuestion::where('report_id', $report->id)->delete();

            $report->status = 2;
            $report->finish_time = Carbon::now();
            $report->score = 100; //TODO: Add Get Score
            $report->save();

            return redirect(route('tryout.level.index', ['id' => $level->id]));
        }
    }

    private function _show_exam($report, $sublevel, $number = 1)
    {
        $report_id = $report->id;
        $sublevel_id = $sublevel->id;
        if (
            !$this->_isExamAvailalable($report, $sublevel) ||
            !$this->_isAuthorizedUser($report)
        ) {
            return response('Forbidden', $status = 403);
        }

        $course_title = $this->_get_course_title($sublevel['course_level_id']);

        $current_number = $number;
        $remaining_time = $this->_get_remaning_time($report, $sublevel);

        $question_numbers = $this->_get_question_numbers($sublevel_id, $report_id);
        $question = $this->_get_question($sublevel_id, $current_number);
        $question['answers'] = $this->_get_answers($question->id);

        $next_available = ($current_number < $question_numbers->count())  ? '' : 'disabled';
        $prev_available = ($current_number > 1) ? '' : 'disabled';

        return view('tryout.questions', compact([
            'sublevel',
            'course_title',
            'current_number',
            'question_numbers',
            'question',
            'remaining_time',
            'next_available',
            'prev_available',
            'report_id'
        ]));
    }

    private function _createReports($sublevel_id)
    {
        $report = new Report;
        $report->student_id = auth()->guard('student')->user()->id;
        $report->course_sublevel_id = $sublevel_id;
        $report->score = 0.0;
        $report->status = 1;
        $report->finish_time = null;
        $report->save();

        return $report;
    }

    private function _get_course_title($level_id)
    {
        $level = CourseLevel::where('id', $level_id)->first();
        $course = Course::where('id', $level['course_id'])->first();
        return $course['title'] . ' - ' . $level['title'];
    }

    private function _get_remaning_time($report, $sublevel)
    {
        $remaining_time = new Carbon($report['created_at']);
        $remaining_time = $remaining_time->addMinute($sublevel['time']);
        $remaining_time = new Carbon($remaining_time->diffInSeconds(Carbon::now()));

        return $remaining_time;
    }

    private function _isAuthorizedUser($report)
    {
        return $report['student_id'] == auth()->guard('student')->user()->id;
    }

    private function _isExamAvailalable($report, $sublevel)
    {
        $time = $sublevel['time'];

        $time_start = new Carbon($report['created_at']);
        $time_start->addMinutes($time);

        return $time_start > Carbon::now() && $report['status'] == 1;
    }

    private function _get_question($sublevel_id, $number)
    {
        return Question::where('course_sublevel_id', '=', $sublevel_id)
            ->where('number', $number)
            ->first();
    }

    private function _get_answers($question_id)
    {
        return MultipleChoiceAnswer::where('question_id', '=', $question_id)
            ->orderBy('answer_order')
            ->get();
    }

    private function _get_question_numbers($sublevel_id, $report_id)
    {
        return Question::where('course_sublevel_id', $sublevel_id)
            ->with(['marked' => function ($query) use ($report_id) {
                $query->where('report_id', $report_id);
            }])
            ->orderBy('number')
            ->get(['id', 'number']);
    }
}
