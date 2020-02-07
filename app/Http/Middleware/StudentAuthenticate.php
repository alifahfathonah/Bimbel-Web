<?php

namespace App\Http\Middleware;

use Closure;

class StudentAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->guard('student')->check()) {
            return redirect(route('tryout.login'));
        }
        return $next($request);
    }

    //TODO:Rediret to home if loggedin
}
