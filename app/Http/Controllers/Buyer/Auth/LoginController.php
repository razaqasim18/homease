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

        // now we use the Auth to Authenticate the users Credentials

        // Attempt Login for members
        if (Auth::guard('buyer')->attempt(['email' => $email, 'password' => $password], $rememberToken)) {
            $user = \Auth::guard('buyer')->user();

            $output = ["type" => 1, "msg" => "Login Successful"];
        } else {
            $output = ["type" => 0, "msg" => "Invalid Login credential"];
        }
        return response()->json($output);
    }
}