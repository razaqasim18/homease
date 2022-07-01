<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Hiring;
use App\Models\Review;
use App\Models\Seller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{

    public function index()
    {
        $data['jobs'] = Hiring::select('sellers.name AS sellername', 'services.title AS servicetitle',
            'hirings.id AS jobid', 'hirings.status As jobstatus', 'services.price AS price', 'hirings.created_at As date')
            ->join('sellers', 'sellers.id', '=', 'hirings.seller_id')
            ->join('services', 'services.id', '=', 'hirings.service_id')
            ->where('buyer_id', auth('buyer')->user()->id)->get();
        return view('buyer.job.list', $data);
    }

    public function delete($id)
    {
        $response = Hiring::findOrFail($id)->delete();
        if ($response) {
            $type = 1;
            $msg = 'Data is deleted successfully';
        } else {
            $type = 0;
            $msg = 'Something went wrong';
        }
        $result = ['type' => $type, 'msg' => $msg];
        echo json_encode($result);
        exit;
    }

    public function approve($id)
    {
        $response = Hiring::findOrFail($id)->update([
            'status' => 4,
        ]);
        if ($response) {
            $Hiring = Hiring::findOrFail($id)->first();
            $service = Service::findOrFail($Hiring->service_id)->first();
            $seller = Seller::findOrFail($Hiring->seller_id)->first();
            Mail::send('seller.job.accept_job_mail', [
                'title' => "Job Approve Mail",
                'msg' => "Your " . $service->title . " Service Have Been Approved",
            ], function ($message) use ($seller) {
                $message->to($seller->email);
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

    public function review($id)
    {
        $id = base64_decode($id);
        $data['review'] = Hiring::where("id", $id)->first();
        $data['reviewexists'] = Review::where("hiring_id", $id)->first();
        return view('buyer.job.review', $data);
    }

    public function postReview(Request $request)
    {

        if ($request->ajax()) {
            $seller_id = $request->get('seller_id');
            $service_id = $request->get('service_id');
            $hiring_id = $request->get('hiring_id');
            $buyer_id = auth('buyer')->user()->id;
            $rating = $request->get('rating');
            $comment = $request->get('comment');
            $response = '';
            $response = \DB::transaction(function () use ($seller_id, $service_id, $hiring_id, $buyer_id, $rating, $comment, $response) {
                Review::create([
                    'service_id' => $service_id,
                    'seller_id' => $seller_id,
                    'buyer_id' => $buyer_id,
                    'hiring_id' => $hiring_id,
                    'rating' => $rating,
                    'comment' => $comment,
                ]);
                $average_rating = 0;
                $total_review = 0;
                $total_user_rating = 0;
                $result = Review::where('service_id', $service_id)->get();
                foreach ($result as $row) {
                    $total_review++;
                    $total_user_rating = $total_user_rating + $row->rating;
                }
                $average_rating = ($total_review != 0) ? $total_user_rating / $total_review : $total_user_rating;
                $average_rating = number_format($average_rating, 1);
                Service::whereId($service_id)->update([
                    'rating' => $average_rating,
                ]);
                Hiring::whereId($hiring_id)->update([
                    'status' => 5,
                ]);

            });
            if (!$response) {
                $output = ['type' => 1, 'msg' => "Data is saved successfully"];
            } else {
                $output = ['type' => 0, 'msg' => 'Something went wrong'];
            }
            echo json_encode($output);
            exit;
        }
    }

    public function reviewView($id)
    {
        $id = base64_decode($id);
        $data['reviewexists'] = Review::where("hiring_id", $id)->first();
        return view('buyer.job.review_view', $data);
    }

}