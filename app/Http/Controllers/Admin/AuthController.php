<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            "username"     => "required|exists:users,username",
            "password"    => "required|min:4",
        ]);

        if (Auth::attempt(['username' => $request['username'], 'password' => $request['password']])) {
            return redirect()->intended(route('admin.dashboard'));
        }
        redirect()->back()->with(['error' => 'Email / Password Salah']);
    }

    public function loginForm()
    {
        //TODO: Redirect to dashboard if loggedin
        return view('admin.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('admin.login'));
    }

}
