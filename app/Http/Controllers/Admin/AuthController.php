<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /** Show login page */
    public function loginForm()
    {
        return view('admin.login');
    }

    /** Proceed login request */
    public function login(Request $request)
    {
        $this->validate($request, [
            "username" => "required|exists:users,username",
            "password" => "required|min:4",
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->route('admin.login')
                         ->withErrors(['password'=>['Wrong Password']])
                         ->withInput(['username' => $request['username']]);
    }

    /** Proceed logout request */
    public function logout()
    {
        Auth::logout();
        return redirect(route('admin.login'));
    }

}
