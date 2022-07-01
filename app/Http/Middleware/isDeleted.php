<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class isDeleted
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
        if (Auth::guard('seller')->check()) {
            if (Auth::guard('seller')->user()->isdeleted == 1) {
                Auth::guard('seller')->logout();
                return redirect()->route('seller.login')->with('error', "Your account is not deleted")->withInput();
                die;
            }
        }
        if (Auth::guard('buyer')->check()) {
            if (Auth::guard('buyer')->user()->isdeleted == 1) {
                Auth::guard('buyer')->logout();
                return redirect()->route('buyer.login')->with('error', "Your account is not deleted")->withInput();
                die;
            }
        }
        return $next($request);
    }
}