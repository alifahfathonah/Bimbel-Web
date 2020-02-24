<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StudentController extends Controller
{
    /** Display a listing of the resource. */
    public function index()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    /** Show the form for creating a new resource. */
    public function create()
    {
        return view('admin.students.create');
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $this->validateRequest();
        $this->validateUsername();

        $student = new Student;
        $student->name = $request['name'];
        $student->username = $request['username'];
        $student->password = '12345678';
        $student->password_enable = isset($request['password_enable']) ? 1 : 0;
        $student->save();

        return redirect()->route('admin.students.index')->with([
            'status' => 'success',
            'message' => 'Add Student ' . $request['username'] . ' Successfull'
        ]);
    }

    /** Display the specified resource. */
    public function show($id)
    {
        $reports = Report::where('student_id', $id)
                    ->with(['student', 'sublevel'])
                    ->get()
                    ->toArray();

        $student = Student::find($id);
        return view('admin.students.show', compact('student', 'reports'));
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        $student = Student::find($id);
        return view('admin.students.edit', compact('student'));
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        $this->validateRequest();
        $this->validateUsername($id);

        $student = Student::find($id);
        $student->name = $request['name'];
        $student->username = $request['username'];
        $student->password_enable = (isset($request['password_enable'])) ? 1 : 0;
        $student->save();

        return redirect()->route('admin.students.index')->with([
            'status' => 'success',
            'message' => 'Update Student ' . $student->username . ' Successfull'
        ]);
    }

    /** Remove the specified resource from storage. */
    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();

        return redirect()->route('admin.students.index')->with([
            'status' => 'success',
            'message' => "Delete $student->username Successfull"
        ]);
    }

    /** Validate name */
    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required|min:3|max:50',
        ]);
    }

    /** Validate password and password_confirmation */
    private function validatePassword()
    {
        return request()->validate([
            'password' => 'required|min:5|max:50|confirmed',
        ]);
    }

    /** Validate username */
    private function validateUsername($id = null)
    {
        $id = isset($id) ? (',' . $id) : '';

        return request()->validate([
            'username' => 'required|max:50|min:5|unique:students,username' . $id,
        ]);
    }


}
