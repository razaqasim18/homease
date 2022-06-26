<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile');
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
        if (!empty($request->file('image'))) {
            $fileName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/profile'), $fileName);
        } else {
            // $name = $request->file('image')->getClientOriginalName();
            // $path = $request->file('image')->store('public/uploads');
            $fileName = $request->showimage;
        }
        $user = Auth::user();
        $user->name = $name;
        $user->username = $username;
        $user->phone = $phone;
        $user->image = $fileName;
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
        $user = Admin::find(Auth::guard('admin')->user()->id);
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
        $user = Auth::user();
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