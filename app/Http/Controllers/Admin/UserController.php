<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Seller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function buyerList()
    {
        $data['users'] = Buyer::all();
        return view('admin.user.buyer', $data);
    }
    public function buyerBlock(Request $request, $id)
    {
        $status = $request->status;
        $response = Buyer::findOrFail($id)->update([
            'isblocked' => $status,
        ]);
        if ($response) {
            $msg = ($status) ? "User is block successful" : "User is unblock successful";
            $result = ["type" => 1, "msg" => $msg];
        } else {
            $result = ["type" => 0, "msg" => "Something is went wrong"];
        }
        echo json_encode($result);
        exit;
    }
    public function buyerDelete(Request $request, $id)
    {
        $status = $request->status;
        $response = Buyer::findOrFail($id)->update([
            'isdeleted' => $status,
        ]);
        if ($response) {
            $msg = ($status) ? "User is deleted successful" : "User is restored successful";
            $result = ["type" => 1, "msg" => $msg];
        } else {
            $result = ["type" => 0, "msg" => "Something is went wrong"];
        }
        echo json_encode($result);
        exit;
    }
    public function sellerList()
    {
        $data['users'] = Seller::all();
        return view('admin.user.seller', $data);
    }
    public function SellerBlock(Request $request, $id)
    {
        $status = $request->status;
        $response = Seller::findOrFail($id)->update([
            'isblocked' => $status,
        ]);
        if ($response) {
            $msg = ($status) ? "User is block successful" : "User is unblock successful";
            $result = ["type" => 1, "msg" => $msg];
        } else {
            $result = ["type" => 0, "msg" => "Something is went wrong"];
        }
        echo json_encode($result);
        exit;
    }
    public function SellerDelete(Request $request, $id)
    {
        $status = $request->status;
        $response = Seller::findOrFail($id)->update([
            'isdeleted' => $status,
        ]);
        if ($response) {
            $msg = ($status) ? "User is deleted successful" : "User is restored successful";
            $result = ["type" => 1, "msg" => $msg];
        } else {
            $result = ["type" => 0, "msg" => "Something is went wrong"];
        }
        echo json_encode($result);
        exit;
    }
}