<?php

namespace App\Http\Middleware;

use Closure;

class StatusMiddleware
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

        if ($request->user()->status == 'pending') {
                return back()->with('message', 'Your account is waiting for approval from the admin!');
        }elseif ($request->user()->status == 'inactive') {
                return back()->with('message', 'Account is inactive');
        }

        return $next($request);
    }
}
