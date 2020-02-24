<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLevel;
use App\Models\CourseSublevel;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|min:3|max:50',
        ]);

        $level = CourseLevel::create($request->all());

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "Add $level->title Successfull"
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:50',
        ]);

        $level = CourseLevel::find($id);
        $level->update($request->all());

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "Update $level->title Successfull"
        ]);
    }

    public function destroy($id)
    {
        $level = CourseLevel::find($id);
        $level->delete();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "Delete $level->title Successfull"
        ]);
    }

}
