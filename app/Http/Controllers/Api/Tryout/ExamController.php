<?php

namespace App\Http\Controllers\Api\Tryout;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\CourseSublevel;
use App\Models\MarkedQuestion;
use App\Models\Question;
use App\Models\Report;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    /** Get rquired property to start exams */
    public function prepare(Request $request)
    {
        $this->validate($request, [
            'report_id' => 'required|exists:reports,id',
        ]);

        $report = Report::find($request['report_id']);
        $sublevel = CourseSublevel::find($report['course_sublevel_id']);
        $level = CourseLevel::find($sublevel['course_level_id']);
        $course = Course::find($level['course_id']);

        $time_limits = $this->_getTimeLimits($report, $sublevel);

        $this->_isExamAvailalable($report, $sublevel, $time_limits);

        $questions = Question::where('course_sublevel_id', '=', $report['course_sublevel_id'])
                ->with([
                    'answer' => function ($query) use ($report) {
                        $query->where('report_id', $report['id'])->select('question_id', 'multiple_choice_id');
                    },
                    'choices' => function ($query) {
                        $query->select('id', 'question_id', 'answer');
                    },
                    'marked' => function ($query) use ($report) {
                        $query->where('report_id', $report['id'])->select('number', 'report_id', 'status');
                    }
                ])
                ->orderBy('number')
                ->get(['id', 'question', 'type', 'number'])
                ->toArray();


        return [
            'questions' => $questions,
            'time_limit' => $time_limits,
            'report_id' => $report['id'],
            'start_time' => $report['created_at'],
            'time' => $sublevel['time'],
            'minimum_score' => $sublevel['minimum_score'],
            'course_id' => $course['id'],
            'level_id' => $level['id'],
            'sublevel_id' => $sublevel['id'],
            'course_title' => $course['title'],
            'level_title' => $level['title'],
            'sublevel_title' => $sublevel['title'],
        ];
    }

    /** Mark question by report_id */
    public function mark(Request $request)
    {
        $this->validate($request, [
            'report_id' => 'required|exists:reports,id',
            'action' => 'required|string'
        ]);

        $report = Report::find($request['report_id']);
        $sublevel_id = $report->course_sublevel_id;

        $this->validate($request, [
            'number' => [
                'required',
                Rule::exists('questions', 'number')->where(function ($query) use ($sublevel_id) {
                    $query->where('course_sublevel_id', $sublevel_id);
                }),
            ]
        ]);

        $mark = MarkedQuestion::where('report_id', $request['report_id'])
                                ->where('number', $request['number'])
                                ->first();

        if (!$mark){
            $mark = new MarkedQuestion;
            $mark->report_id = $request['report_id'];
            $mark->number = $request['number'];
        }

        $mark->status = $request['action'] == 'mark' ? 1 : 0;
        $mark->save();

        return response()->json([
            'status' => $mark ? 'success':'fail',
            'mark' => $mark
        ], 200);
    }

    /** Save student answer to database */
    public function answer(Request $request)
    {
        $this->validate($request, [
            'report_id' => 'required|exists:reports,id',
            'multiple_choice_id' => 'required|exists:multiple_choice_answers,id',
            'question_id' => 'required|exists:questions,id'
        ]);

        $answer = StudentAnswer::where('report_id', $request['report_id'])
                                ->where('question_id', $request['question_id'])
                                ->first();
        if (!$answer){
            $answer = new StudentAnswer;
            $answer->report_id = $request['report_id'];
            $answer->question_id = $request['question_id'];
        }

        $answer->multiple_choice_id = $request['multiple_choice_id'];
        $result = $answer->save();

        return response()->json([
            'status' => $result ? 'success' : 'fail',
            'answer' => $answer
        ], 200);
    }

    /** Submit the exams */
    public function submit(Request $request)
    {
        $this->validate($request, [
            'report_id' => 'required',
        ]);

        $report = Report::where('id', $request['report_id'])
                            ->where('status', 1)
                            ->first();

        if (!$report){
            return 'Invalid report_id';
        }

        $sublevel = CourseSublevel::find($report['course_sublevel_id']);
        $time_limit = $this->_getTimeLimits($report, $sublevel);

        $result = $this->_getExamResult($report);

        $report->status = 2;
        $report->finish_time = $this->_isTimeLimitExceeded($time_limit) ? $time_limit : Carbon::now();
        $report->score = $result['score'];
        $report->save();

        $sublevel = CourseSublevel::find($report->course_sublevel_id, ['course_level_id']);

        return redirect()->route('tryout.exams.show', [
            'level_id' => $sublevel->course_level_id,
        ]);
    }




    //Helpers

    /** Get exams results */
    private function _getExamResult($report){
        $question_count = Question::where('course_sublevel_id', $report->course_sublevel_id)->count();
        $score_step = 100/$question_count;
        $answers = StudentAnswer::where('report_id', $report->id)
                        ->with([
                            'choice' => function($query) use($report){
                                $query->select('id', 'order', 'is_correct');
                            }
                        ])
                        ->orderBy('question_id')
                        ->get(['id', 'question_id', 'multiple_choice_id'])
                        ->toArray();

        $correct_answer_count = 0;
        $wrong_answer_count = 0;
        $answered_count = count($answers);

        foreach ($answers as $answer) {
            if ($answer['choice']['is_correct'] == 1)
                $correct_answer_count++;
            else
                $wrong_answer_count++;
        }

        $score = $this->_toDecimal($correct_answer_count * $score_step);

        return [
            'question_count' => $question_count,
            'answered_count' => $answered_count,
            'correct_answer_count' => $correct_answer_count,
            'wrong_answer_count' => $wrong_answer_count,
            'score_step' => $score_step,
            'score' => $score,
            // 'max_score' => $score_step * $question_count,
            // 'details' => $answers,
        ];
    }

    /** Convert number to decimal */
    private function _toDecimal($number, $decimal = 2)
    {
        return (float) number_format((float) $number, $decimal, '.', '');
    }

    /** Delete marked question by report_id */
    private function _deleteMarkedQuestion($report_id)
    {
        MarkedQuestion::where('report_id', $report_id)->delete();
    }

    /** Get exam time limits */
    private function _getTimeLimits($report, $sublevel)
    {
        return (new Carbon($report['created_at']))->addMinute($sublevel['time']);
    }

    /** Check current user is authorized on exam */
    private function _isAuthorizedUser($report)
    {
        return $report['student_id'] == auth()->guard('student')->user()->id;
    }

    /** Check is exam still available */
    private function _isExamAvailalable($report, $sublevel, $time_limit)
    {
        if (!$this->_isExamWasDone($report) ||
            !$this->_isAuthorizedUser($report) ||
            !$this->_isTimeLimitExceeded($time_limit)
        ) {

            if (!$this->_isTimeLimitExceeded($time_limit)) {
                return 'Time Limits Was Exceeded';
                // $this->_setExamAsDone($report, $sublevel, $time_limit);
            }

            return '403 Forbidden';
        }
    }

    /** Check is time limits was exceeded */
    private function _isTimeLimitExceeded($time_limit)
    {
        return $time_limit < Carbon::now();
    }

    /** Check is exam has been done */
    private function _isExamWasDone($report)
    {
        return $report['status'] == 2;
    }

}
