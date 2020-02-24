<?php

namespace App\Http\Controllers\Tryout;

use App\Http\Controllers\Controller;
use App\Models\Student;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TryoutController extends Controller
{
    /** Show students dashboard */
    public function dashboard()
    {
        return view('tryout.dashboard');
    }

    /** Show student profile */
    public function profile()
    {
        $user = auth()->guard('student')->user()->toArray();
        return view('tryout.profile', compact('user'));
    }

    /** Edit user password enable */
    public function edit_profile(Request $request)
    {
        $password_enable = isset($request['password_enable']) ? 1 : 0;
        $user = auth()->guard('student')->user();
        $user->password_enable = $password_enable;
        $user->save();

        return redirect()->route('tryout.profile')->with([
            'status' => 'success',
            'message' => 'Update Profile Successfull'
        ]);
    }

    /** Change password */
    public function change_password(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|min:5|max:50',
            'new_password' => 'required|min:5|max:50|confirmed'
        ]);

        $user = auth()->guard('student')->user();

        if (Hash::check($request['old_password'], $user->password)){
            $user->password = bcrypt($request['new_password']);
            $user->save();

            return redirect()->route('tryout.profile')->with([
                'status' => 'success',
                'message' => 'Change Password Successfull'
            ]);
        }

        return redirect()->route('tryout.profile')->withErrors(['old_password' => ['Wrong Password']]);

    }
}
