<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Hiring;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    public function index()
    {
        $data['jobs'] = Hiring::select('buyers.name AS buyername', 'services.title AS servicetitle',
            'hirings.id AS jobid', 'hirings.status As jobstatus', 'services.price AS price', 'hirings.created_at As date')
            ->join('buyers', 'buyers.id', '=', 'hirings.buyer_id')
            ->join('services', 'services.id', '=', 'hirings.service_id')
            ->where('hirings.seller_id', auth('seller')->user()->id)->get();
        return view('seller.job.list', $data);
    }
    public function cancel($id)
    {
        $response = Hiring::findOrFail($id)->update([
            'status' => -1,
        ]);
        if ($response) {
            $type = 1;
            $msg = 'Job is cancelled successfully';
        } else {
            $type = 0;
            $msg = 'Something went wrong';
        }
        $result = ['type' => $type, 'msg' => $msg];
        echo json_encode($result);
        exit;
    }

    public function accept($id)
    {
        $response = Hiring::findOrFail($id)->update([
            'status' => 1,
        ]);
        if ($response) {
            $Hiring = Hiring::findOrFail($id)->first();
            $service = Service::findOrFail($Hiring->service_id)->first();
            $buyer = Buyer::findOrFail($Hiring->buyer_id)->first();
            Mail::send('seller.job.accept_job_mail', [
                'title' => "Job Acceptance Mail",
                'msg' => "Your " . $service->title . " Service Have Been Accepted",
            ], function ($message) use ($buyer) {
                $message->to($buyer->email);
                $message->subject('Job Acceptance Mail');
            });
            $type = 1;
            $msg = 'Job is accepted successfully';
        } else {
            $type = 0;
            $msg = 'Something went wrong';
        }
        $result = ['type' => $type, 'msg' => $msg];
        echo json_encode($result);
        exit;
    }

    public function start($id)
    {
        $response = Hiring::findOrFail($id)->update([
            'status' => 2,
        ]);
        if ($response) {
            $Hiring = Hiring::findOrFail($id)->first();
            $service = Service::findOrFail($Hiring->service_id)->first();
            $buyer = Buyer::findOrFail($Hiring->buyer_id)->first();
            Mail::send('seller.job.accept_job_mail', [
                'title' => "Job Start Mail",
                'msg' => "Your " . $service->title . " Service Have Been Started",
            ], function ($message) use ($buyer) {
                $message->to($buyer->email);
                $message->subject('Job Start Mail');
            });
            $type = 1;
            $msg = 'Job is started successfully';
        } else {
            $type = 0;
            $msg = 'Something went wrong';
        }
        $result = ['type' => $type, 'msg' => $msg];
        echo json_encode($result);
        exit;
    }

    public function finish($id)
    {
        $response = Hiring::findOrFail($id)->update([
            'status' => 3,
        ]);
        if ($response) {
            $Hiring = Hiring::findOrFail($id)->first();
            $service = Service::findOrFail($Hiring->service_id)->first();
            $buyer = Buyer::findOrFail($Hiring->buyer_id)->first();
            Mail::send('seller.job.accept_job_mail', [
                'title' => "Job Finish Mail",
                'msg' => "Your " . $service->title . " Service Have Been Finished",
            ], function ($message) use ($buyer) {
                $message->to($buyer->email);
                $message->subject('Job Finish Mail');
            });
            $type = 1;
            $msg = 'Job is finished successfully';
        } else {
            $type = 0;
            $msg = 'Something went wrong';
        }
        $result = ['type' => $type, 'msg' => $msg];
        echo json_encode($result);
        exit;
    }

    public function reviewView($id)
    {
        $id = base64_decode($id);
        $data['reviewexists'] = Review::where("hiring_id", $id)->first();
        return view('seller.job.review_view', $data);
    }
}