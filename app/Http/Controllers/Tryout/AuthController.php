<?php

namespace App\Http\Controllers\Tryout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /** Show login page */
    public function loginForm()
    {
        return view('tryout.login');
    }

    /** Proceed login request */
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
        return back()
                ->withErrors(['password' => ['Wrong Password']])
                ->withInput(['username' => $request['username']]);
    }

    /** Proceed logout request */
    public function logout()
    {
        auth()->guard('student')->logout();
        return redirect(route('tryout.login'));
    }

}
