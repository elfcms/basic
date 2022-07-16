<?php

namespace Elfcms\Basic\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminUser
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
        //dd($request->method());
        if ($request->method() == 'POST') {
            return $next($request);
        }
        if (Auth::check()) {
            $user = Auth::user();
            if ($user) {
                foreach ($user->roles as $role) {
                    if ($role->code == 'admin') {
                        return $next($request);
                    }
                }
            }
        }

        if (Route::currentRouteName() != 'admin.login') {
            return redirect()->guest(route('admin.login'));
        }

        return $next($request);
    }
}
