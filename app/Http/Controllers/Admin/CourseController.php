<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest();

        $course = new Course;
        $course->title = $request['title'];
        $course->save();

        return redirect()->route('admin.levels.index')->with([
            'status' => 'success',
            'message' => "Add $course->title Successfull"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($id);

        $course = Course::find($id);
        $course->title = $request['title'];
        $course->save();

        return redirect()->route('admin.levels.index')->with([
            'status' => 'success',
            'message' => "Update $course->title Successfull"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();

        return redirect()->route('admin.levels.index')->with([
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
