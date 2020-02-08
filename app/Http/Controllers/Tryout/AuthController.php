<?php

namespace App\Http\Controllers\Tryout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('tryout.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|exists:students,username',
            'password' => 'required|string'
        ]);

        $auth = $request->only('username', 'password');

        if (auth()->guard('student')->attempt($auth)) {
            return redirect()->intended(route('tryout.dashboard'));
        }
        redirect()->back()->with(['error' => 'Email / Password Salah']);
    }

    public function logout()
    {
        auth()->guard('student')->logout();
        return redirect(route('tryout.login'));
    }

}
