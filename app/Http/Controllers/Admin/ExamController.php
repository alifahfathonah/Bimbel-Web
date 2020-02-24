<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\CourseSublevel;

class ExamController extends Controller
{
    /** Show all course with all levels */
    public function index()
    {
        $courses = Course::with('course_levels', 'course_levels.course_sublevels')->get();
        return view('admin.levels.index', compact('courses'));
    }

    /** Show all sublevel in selected level */
    public function level_show($level_id)
    {
        $level = CourseLevel::find($level_id);
        $course = Course::find($level->course_id);
        $sublevels = CourseSublevel::where('course_level_id', $level_id)->get()->toArray();

        return view('admin.levels.show', compact('course', 'level', 'sublevels'));
    }

    /** Show create sublevel Form */
    public function sublevel_create($level_id)
    {
        $level = CourseLevel::find($level_id);
        $course = Course::find($level->course_id);
        return view('admin.levels.create', compact('level', 'course'));
    }

    /** Show edit sublevel form */
    public function sublevel_edit($level_id, $sublevel_id)
    {
        $level = CourseLevel::find($level_id);
        $course = Course::find($level->course_id);
        $sublevel = CourseSublevel::find($sublevel_id);
        return view('admin.levels.edit', compact('level', 'course', 'sublevel'));
    }

    /** Show manage questions page */
    public function manage_question($level_id, $sublevel_id)
    {
        $sublevel = CourseSublevel::find($sublevel_id);
        $level = CourseLevel::find($level_id);
        $course = Course::find($level['course_id']);
        return view('admin.levels.manage_question', compact('course', 'level', 'sublevel'));
    }

}
