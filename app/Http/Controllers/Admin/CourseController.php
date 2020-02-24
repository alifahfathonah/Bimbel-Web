<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function store(Request $request)
    {
        $this->validateRequest();

        $course = Course::create($request->all());

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "Add $course->title Successfull"
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($id);

        $course = Course::find($id);
        $course->update($request->all());

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "Update $course->title Successfull"
        ]);
    }

    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "Delete $course->title Successfull"
        ]);
    }

    public function validateRequest($id = null)
    {
        $id = isset($id) ? (',' . $id) : '';

        return request()->validate([
            'title' => 'required|min:3|max:50|unique:courses,title' . $id,
        ]);
    }

}
