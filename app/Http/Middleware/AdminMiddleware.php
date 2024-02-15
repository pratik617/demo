<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // return $next($request);

        if (!Auth::guard('web')->check()) {
            return redirect()->route('admin.login');
        }

        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.login')->with('error', 'You have not rights to access to this area');
        }

        return $next($request);
    }
}
