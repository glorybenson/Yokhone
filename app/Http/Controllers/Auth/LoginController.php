<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirectTo()
    {
        foreach (Auth::user()->roles as $role) {
            return '/dashboard';
            // switch ($role) {
            //     case '1':
            //         return '/home';
            //         break;
            //     case '2':
            //         return '/home';
            //         break;
            //     case '3':
            //         return '/clients';
            //         break;
            //     case '4':
            //         return '/farms';
            //         break;
            //     case '5':
            //         return '/employees';
            //         break;
            //     case '6':
            //         return '/expenses';
            //         break;
            //     default:
            //         return '/home';
            //         break;
            // }
        }
    }
}