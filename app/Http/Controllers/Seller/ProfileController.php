<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('seller.profile');
    }

    public function store(Request $request)
    {
        $name = $request->name;
        $username = $request->username;
        $phone = $request->phone;
        $error = '';
        if (empty($name)) {
            $error .= "Name is required" . "\n";
        }
        if (empty($username)) {
            $error .= "Username is required" . "\n";
        }
        if (empty($phone)) {
            $error .= "Phone is required" . "\n";
        }
        if (!empty($error)) {
            $result = ['type' => 0, 'msg' => $error];
            echo json_encode($result);
            exit;
        }
        $fileName = null;
        if (!empty($request->file('image'))) {
            $fileName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/seller'), $fileName);
        } else {
            // $name = $request->file('image')->getClientOriginalName();
            // $path = $request->file('image')->store('public/uploads');
            $fileName = $request->showimage;
        }
        $user = Auth::guard('seller')->user();
        $user->name = $name;
        $user->username = $username;
        $user->phone = $phone;
        if ($fileName) {
            $user->image = $fileName;
        } else {
            $user->image = null;
        }
        if ($user->save()) {
            $type = 1;
            $msg = 'Data is saved successfully';
        } else {
            $type = 0;
            $msg = 'Something went wrong';
        }
        $result = ['type' => $type, 'msg' => $msg];
        echo json_encode($result);
        exit;
    }

    public function passwordChange(Request $request)
    {
        $oldpassword = $request->oldpassword;
        $newpassword = $request->newpassword;
        $confpassword = $request->confpassword;
        $error = '';
        if (empty($oldpassword)) {
            $error .= "Old password is required" . "\n";
        }
        if (empty($newpassword)) {
            $error .= "New password is required" . "\n";
        }
        if (empty($confpassword)) {
            $error .= "Confirm password required" . "\n";
        }
        if ($newpassword != $confpassword) {
            $error .= "New password and confirm password should be same" . "\n";
        }
        $user = Seller::find(Auth::guard('seller')->user()->id);
        if (!Hash::check($oldpassword, $user->password)) {
            $error .= "Old password is incorrect" . "\n";
        }
        if ($newpassword == $oldpassword) {
            $error .= "New password and old password should not be same" . "\n";
        }
        if (!empty($error)) {
            $result = ['type' => 0, 'msg' => $error];
            echo json_encode($result);
            exit;
        }
        $user = Auth::guard('seller')->user();
        $user->password = Hash::make($request->newpassword);
        if ($user->save()) {
            $type = 1;
            $msg = 'Data is saved successfully';
        } else {
            $type = 0;
            $msg = 'Something went wrong';
        }
        $result = ['type' => $type, 'msg' => $msg];
        echo json_encode($result);
        exit;
    }

}