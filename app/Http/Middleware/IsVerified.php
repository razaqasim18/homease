<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::guard('seller')->check()) {
            if (Auth::guard('seller')->user()->isverified == 0) {
                Auth::guard('seller')->logout();
                return redirect()->route('seller.login')->with('error', "Your account is not verified")->withInput();
                die;
            }
        }
        if (Auth::guard('buyer')->check()) {
            if (Auth::guard('buyer')->user()->isverified == 0) {
                Auth::guard('buyer')->logout();
                return redirect()->route('buyer.login')->with('error', "Your account is not verified")->withInput();
                die;
            }
        }
        // return redirect(RouteServiceProvider::HOME);
        return $next($request);
    }
}