<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseLevel;
use App\Models\CourseSublevel;
use Illuminate\Http\Request;

class SublevelController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            "course_level_id"     => "required|exists:course_levels,id",
        ]);

        $level = CourseLevel::find($request['course_level_id']);
        return view('admin.levels.create', compact('course_level_id'));
    }

    public function store(Request $request)
    {
        $this->validateRequest();
        $sublevel = CourseSublevel::create($request->all());

        return redirect()->route('admin.exams.level.show', ['level_id' => $request['course_level_id']])->with([
            'status' => 'success',
            'message' => 'Create ' . $sublevel->title . " Successfull",
        ]);
    }

    public function edit($id)
    {
        $sublevel = CourseSublevel::find($id);
        return view('admin.levels.edit', compact('sublevel'));
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest();

        $sublevel = CourseSublevel::find($id);
        $sublevel->update($request->all());

        return redirect()
            ->route('admin.exams.level.show', ['level_id' => $sublevel['course_level_id']])
            ->with(['status' => 'success', 'message' => 'Update ' . $sublevel->title . " Successfull",]);
    }

    public function destroy($id)
    {
        $sublevel = CourseSublevel::find($id);
        $sublevel->delete();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Delete ' . $sublevel->title . " Successfull",
        ]);
    }

    public function validateRequest()
    {
        request()->validate([
            'title' => 'required|min:3|max:50',
            'minimum_score' => 'required|numeric|min:0|max:100',
            'time' => 'required|numeric|min:0',
            'course_level_id' => 'required|exists:course_levels,id',
            'description' => 'required',
        ]);
    }

}
