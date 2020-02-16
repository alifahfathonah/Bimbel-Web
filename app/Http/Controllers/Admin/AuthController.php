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
        $validator = $this->validate($request, [
            "username"     => "required|exists:users,username",
            "password"    => "required|min:4",
        ]);

        // dd($validator);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->route('admin.login')->withErrors(['password'=>['Wrong Password']])
        ->withInput(['username' => $request['username']]);
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
