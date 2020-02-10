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
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TryoutController extends Controller
{
    public function dashboard()
    {
        return view('tryout.dashboard');
    }

    public function course_index()
    {
        $courses = Course::with('course_levels', 'course_levels.course_sublevels')->get();
        return view('tryout.course', compact('courses'));
    }

    public function level_index($id)
    {
        $student_id = auth()->guard('student')->user()->id;
        $sublevels = DB::table('course_sublevels')
                        ->where('course_level_id', $id)
                        ->leftJoin('reports', function ($join) use ($student_id){
                            $join->on('reports.course_sublevel_id', '=', 'course_sublevels.id')
                                 ->where('reports.student_id', '=', $student_id);
                        })
                        ->select(
                            'course_sublevels.id',
                            'course_sublevels.course_level_id',
                            'course_sublevels.title',
                            'course_sublevels.time',
                            'course_sublevels.minimum_score',
                            'course_sublevels.descrption',
                            'reports.id AS report_id',
                            'reports.student_id',
                            'reports.course_sublevel_id',
                            'reports.score',
                            'reports.status',
                            'reports.finish_time',
                            'reports.created_at',
                        )
                        ->get()
                        ->toArray();
        // dd($sublevels);
        return view('tryout.level', compact('sublevels'));


        dd($sublevels);
        $sublevels = CourseSublevel::where('course_level_id', '=', $id)->get();

        $sublevel_ids = array();
        foreach ($sublevels as $sublevel) {
            array_push($sublevel_ids, $sublevel['id']);
        }


        $reports = Report::where('student_id', $student_id)
                    ->whereIn('id', $sublevel_ids)
                    ->get();


        return view('tryout.level', compact('sublevels'));
    }
}
