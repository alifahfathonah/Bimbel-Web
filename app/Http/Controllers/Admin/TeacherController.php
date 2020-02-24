<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /** Display a listing of the resource. */
    public function index()
    {
        $teachers = User::all();
        return view('admin.teachers.index', compact('teachers'));
    }

    /** Show the form for creating a new resource. */
    public function create()
    {

        return view('admin.teachers.create');
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $this->validateRequest();
        $this->validateUsername();
        $this->validatePassword();

        $user = request()->all();
        $user['role'] = 3;
        $user = User::create($user);

        return redirect()->route('admin.teachers.index')->with([
            'status' => 'success',
            'message' => 'Create Teacher Success',
        ]);
    }

    /** Display the specified resource. */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.teachers.show', compact('user'));
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.teachers.edit', compact('user'));
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        $this->validateUsername($id);
        $this->validateRequest();

        $user = User::find($id);
        $user->username = $request['username'];
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->save();

        return redirect()->route('admin.teachers.index')->with([
            'status' => 'success',
            'message' => 'Update Teacher Success',
        ]);
    }

    /** Remove the specified resource from storage. */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('admin.teachers.index')->with([
            'status' => 'success',
            'message' => "Delete Teacher $user->username Successfull"
        ]);
    }

    /** Validate name, email, and username (with unique username) */
    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|min:5|max:50',
        ]);
    }

    /** Validate password and password_confirmation */
    private function validatePassword()
    {
        return request()->validate([
            'password' => 'required|min:5|max:50|confirmed',
        ]);
    }

    /** Validate username (with exeption id) */
    private function validateUsername($id = null)
    {
        if ($id){
            return request()->validate([
                'username' => 'required|max:50|min:5|unique:users,username,' . $id,
            ]);
        }
        return request()->validate([
            'username' => 'required|min:5|max:50|unique:users,username',
        ]);
    }

}
