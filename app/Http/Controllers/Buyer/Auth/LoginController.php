<?php

namespace App\Http\Controllers\Buyer\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesBuyers;
use Illuminate\Http\Request;

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

    use AuthenticatesBuyers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'buyer';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function loginAjax(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $rememberToken = $request->remember;
        if (Auth::guard('buyer')->attempt($request->only('email', 'password'))) {
            // Illuminate\Auth\SessionGuard::updateSession(auth('buyer')->user()->id);
            // updateSession(getAuthIdentifier());
            // auth('buyer')->updateSession(auth('buyer')->user()->id);
            // Auth::guard('buyer')->login();
            // $request->session()->regenerate();
            // session()->put(Auth::getName(), Auth::guard('buyer')->id());

            // session()->migrate(true);
            // Auth::guard('buyer')->login($request);
            // auth('buyer')->check();
            $request->session()->put("LoggedBuyer", Auth::guard('buyer')->id());
            // Auth::guard('buyer')->login(Auth::guard('buyer')->user());

            $output = ["type" => 1, "msg" => "buyer"];
        } else {
            $output = ["type" => 0, "msg" => "Invalid Login credential"];
        }
        echo json_encode($output);
        exit;
    }
}