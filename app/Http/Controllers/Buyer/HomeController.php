<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Hiring;
use App\Models\Seller;
use App\Models\Service;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:buyer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('buyer.home');
    }

    public function hireMe(Request $request)
    {
        $serviceid = $request->serviceid;
        $sellerid = $request->sellerid;
        $buyerid = Auth::guard('buyer')->user()->id;
        $error = '';
        if (empty($serviceid)) {
            $error .= "Service id is required" . "\n";
        }
        if (empty($sellerid)) {
            $error .= "Seller id is required" . "\n";
        }
        if (!empty($error)) {
            $output = ['type' => 0, "msg" => $error];
        } else {
            $data = [
                'service_id' => $serviceid,
                'seller_id' => $sellerid,
                'buyer_id' => $buyerid,
                'status' => 0,
            ];
            if (Hiring::create($data)) {
                $buyer = Buyer::find($buyerid)->first();
                $seller = Seller::find($sellerid)->first();
                $service = Service::find($serviceid)->first();
                // Buyer mail
                Mail::send('buyer_job_mail', [
                    'servicetitle' => $service->title,
                    'selleremail' => $seller->email,
                ], function ($message) use ($buyer) {
                    $message->to($buyer->email);
                    $message->subject('Job Hiring Mail');
                });
                // Seller mail
                Mail::send('buyer_job_mail', [
                    'servicetitle' => $service->title,
                    'buyeremail' => $buyer->email,
                ], function ($message) use ($seller) {
                    $message->to($seller->email);
                    $message->subject('Job Hiring Mail');
                });
                $output = ['type' => 1, "msg" => "Data is saved successfully"];
            } else {
                $output = ['type' => 0, "msg" => "Something went wrong"];
            }
        }
        echo json_encode($output);
        exit;
    }
}