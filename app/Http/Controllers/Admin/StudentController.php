<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $statement = DB::select("SHOW TABLE STATUS LIKE 'students'");
        $new_id = $statement[0]->Auto_increment;

        return view('admin.students.create', compact('new_id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50|min:5',
            'username' => 'required|max:50|min:5|unique:students,username',
            'password_enable' => 'nullable',
        ]);

        $student = new Student;
        $student->name = $request['name'];
        $student->username = $request['username'];
        $student->password = '12345678';
        $student->password_enable = isset($request['password_enable']) ? 1 : 0;

        $student->save();
        return redirect(route('admin.student.index'))->with([
            'status' => 'success',
            'message' => 'Add Student ' . $request['username'] . ' Successfull'
        ]);

        return response()->json([]);
    }

    public function edit($id)
    {
        $student = Student::find($id);

        if (!$student){
            return redirect(route('admin.student.index'));
        }

        $student['join'] = (new Carbon($student['created_at']))->toDayDateTimeString();

        return view('admin.students.details', compact('student'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:students,id',
        ]);

        $user_id = $request['id'];

        $this->validate($request, [
            'name' => 'required|max:50|min:5',
            'password_enable' => 'nullable',
            'username' => [
                'required', 'max:50', 'min:5',
                Rule::unique('students')->ignore($user_id),
            ],
        ]);

        $student = Student::find($user_id);
        $student->name = $request['name'];
        $student->username = $request['username'];
        $student->password_enable = (isset($request['password_enable'])) ? 1 : 0;

        $student->save();

        return redirect(route('admin.student.index'))->with([
            'status' => 'success',
            'message' => 'Update Student ' . $student->username . ' Successfull'
        ]);
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:students,id',
        ]);

        $student = Student::find($request['id']);
        $student->delete();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "Delete $student->username Successfull"
        ]);
    }

}
