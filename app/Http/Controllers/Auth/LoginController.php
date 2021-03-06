<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    public function redirectTo()
    {
        switch (auth()->user()->type) {
            case 'ADMINISTRATOR':
                return route('collector.index');
            case 'COLLECTOR':
                return route('collector.receivement.index', auth()->user()->collector);
        }
    }

    public function showLoginForm()
    {
        return view('auth.login', ["dont_show_navbar" => true]);
    }

    public function loggedOut()
    {
        return redirect()->route('home.show');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }
}
