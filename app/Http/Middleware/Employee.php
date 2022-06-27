<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Employee
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
        if (in_array(1, Auth::user()->roles) || in_array(5, Auth::user()->roles)) {
            return $next($request);
        } else {
            foreach (Auth::user()->roles as $role) {
                return redirect('/home');
                switch ($role) {
                    case 2:
                        Session::flash('permission_warning', 'You no not have access to this page');
                        return redirect('/home');
                        break;
                    case 3:
                        Session::flash('permission_warning', 'You no not have access to this page');
                        return redirect('/clients');
                        break;
                    case 4:
                        Session::flash('permission_warning', 'You no not have access to this page');
                        return redirect('/farms');
                        break;
                    case 6:
                        Session::flash('permission_warning', 'You no not have access to this page');
                        return redirect('/expenses');
                        break;
                    default:
                        break;
                }
            }
        }
    }
}