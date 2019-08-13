<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redirect;

use Closure;
use Session;

class IsLoggedIn
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
        if(!Session::has('username')||!Session::has('password'))
        {
            return redirect::to('login');
        }
        return $next($request);
    }
}
