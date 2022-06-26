<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Foundation\Auth\RegistersSellers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersSellers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'seller';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:seller');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:sellers'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:sellers'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $expireDate = date("Y-m-d", strtotime(date("Y-m-d") . "+1 month"));
        $createUser = Seller::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'location' => $data['location'],
            'expired_at' => $expireDate,
        ]);
        $token = $createUser->id;
        Mail::send('seller.auth.verify', ['token' => base64_encode($token)], function ($message) use ($data) {
            $message->to($data['email']);
            $message->subject('Seller email Verification Mail');
        });
        return $createUser;
    }

    public function verify($token)
    {
        $id = base64_decode($token);
        if (Seller::where('id', $id)->first()) {
            Seller::find($id)->update([
                'isverified' => '1',
            ]);
            return redirect()->route('seller.login')->with('success', 'You are successfully verified');
        } else {
            return redirect()->route('seller.login')->with('error', 'Something went wrong');

        }
    }
}