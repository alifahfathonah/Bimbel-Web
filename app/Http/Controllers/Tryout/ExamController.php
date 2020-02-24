<?php

namespace App\Http\Controllers\Tryout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseSublevel;
use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\Report;

class ExamController extends Controller
{

    /** Show all course and all levels */
    public function index()
    {
        $courses = Course::with('course_levels', 'course_levels.course_sublevels')->get();
        return view('tryout.exams.index', compact('courses'));
    }

    /** Show levels and exam result */
    public function show($level_id)
    {
        $student_id = auth()->guard('student')->user()->id;
        $level = CourseLevel::find($level_id);
        $course = Course::find($level['course_id']);

        $sublevels = CourseSublevel::with([
            'reports' => function ($query) use($student_id) {
                $query->where('student_id', $student_id);
            }
        ])->where('course_level_id', $level_id)->get()->toArray();

        $this->_addExtras($sublevels);

        return view('tryout.exams.show', compact('level', 'course', 'sublevels'));
    }

    /** Create exams with create new reports */
    public function start(Request $request, $level_id, $sublevel_id)
    {
        $this->validate($request, [
            'sublevel_id' => 'required|exists:course_sublevels,id',
        ]);

        $report = $this->_createReports($request['sublevel_id']);

        return redirect()->route('tryout.exams.run', ['id' => $report->id]);
    }

    /** Run exams  */
    public function run(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:reports,id',
        ]);

        $report = Report::find($request['id']);
        $sublevel = CourseSublevel::find($report['course_sublevel_id']);
        $level = CourseLevel::find($sublevel->course_level_id);
        $course = Course::find($level->course_id);

        return view('tryout.exams.exam', compact('report', 'course', 'level', 'sublevel'));
    }


    //Helpers

    /** Create reports by sublevel id */
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

    /** Add type, is_above_min, status, score to sublevels */
    private function _addExtras(&$sublevels)
    {
        foreach ($sublevels as &$sublevel) {
            $sublevel['type'] = 'primary';
            $sublevel['is_above_min'] = false;
            $sublevel['status'] = 0;
            $sublevel['score'] = '-';

            if (count($sublevel['reports']) > 0) {
                $sublevel['status'] = $sublevel['reports'][0]['status'];

                if ($sublevel['status'] == 1) {
                    $sublevel['type'] = 'warning';
                } else if ($sublevel['status'] == 2) {
                    $sublevel['score'] = $sublevel['reports'][0]['score'];
                    if ($sublevel['score'] >= $sublevel['minimum_score']) {
                        $sublevel['is_above_min'] = true;
                        $sublevel['type'] = 'success';
                    } else {
                        $sublevel['is_above_min'] = false;
                        $sublevel['type'] = 'danger';
                    }
                }
            }
        }
    }

}
