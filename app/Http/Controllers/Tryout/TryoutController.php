<?php

namespace App\Http\Controllers\Tryout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseSublevel;
use App\Models\Course;

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
        $sublevels = CourseSublevel::where('course_level_id', '=', $id)->get();
        return view('tryout.level', compact('sublevels'));
    }

}
