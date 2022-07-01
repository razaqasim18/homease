<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Review;
use App\Models\Seller;
use App\Models\Service;
use App\Models\Serviceimage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth', 'verified']);
        Seller::where('expired_at', '<=', Date("Y-m-d"))->update([
            'isexpired' => 1,
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $blog = Blog::all();
        return view('home', [
            'blogs' => $blog,
        ]);
    }
    public function blog()
    {
        return view('blogs', ['blog' => Blog::paginate(6)]);
    }
    public function singleBlog($title, $id)
    {
        return view('blog', [
            'blog' => Blog::findorfail(base64_decode($id)),
            'recentposts' => Blog::orderBy('id', 'DESC')->offset(0)->limit(5)->get()]);
    }
    public function faq()
    {
        return view('faq', ['faq' => Faq::all()]);
    }
    public function services()
    {
        $category = Category::all();
        $data = DB::table('services')
            ->selectRaw("services.id AS serviceid,title,services.created_at,services.image AS image,description,sellers.id,price")
            ->join('sellers', 'sellers.id', '=', 'services.seller_id')
            ->paginate(6);
        return view('services', [
            'category' => $category,
            'data' => $data,
        ]);
    }

    public function searchService(Request $request)
    {
        // if ($request->ajax()) {
        // $sort_by = $request->get('sortby');
        // $sort_type = $request->get('sorttype');

        // this is the near query
        // SELECT latitude, longitude, SQRT(
        // POW(69.1 * (latitude - [startlat]), 2) +
        // POW(69.1 * ([startlng] - longitude) * COS(latitude / 57.3), 2)) AS distance
        // FROM TableName HAVING distance < 25 ORDER BY distance;

        // mine code
        // $category = $request->get('category');
        // $location = $request->get('location');
        // $distance = $request->get('distance');
        // $latitude = $request->get('latitude');
        // $longitude = $request->get('longitude');
        // $location = str_replace(" ", "%", $location);
        // if (!empty($longitude)) {
        //     $data = DB::table('services')
        //         ->selectRaw("price,latitude, longitude, SQRT(POW(69.1 * (latitude -  $latitude), 2) +POW(69.1 * ($longitude - longitude) * COS(latitude / 57.3), 2)) AS distance")
        //         ->join('sellers', 'sellers.id', '=', 'services.seller_id')
        //         ->when($category, function ($query, $category) {
        //             $query->where('category_id', $category);
        //         })
        //     // ->where('address', 'like', '%' . $location . '%')
        //         ->groupBy('services.id')
        //         ->when($distance, function ($query, $distance) {
        //             $query->having('distance', '<', $distance);
        //         })
        //         ->orderBy('distance')
        //         ->paginate(5);
        // } else {
        //     $data = DB::table('services')
        //         ->join('sellers', 'sellers.id', '=', 'services.seller_id')
        //         ->when($category, function ($query, $category) {
        //             $query->where('category_id', $category);
        //         })
        //     // ->where('address', 'like', '%' . $location . '%')
        //         ->groupBy('services.id')
        //         ->orderBy('services.id')
        //         ->paginate(5);
        // }
        // mine code end

        // ->get();

        // $data = DB::table('services')->get();
        // return view('search_service', ['data' => $data]);
        // return view('search_service', compact('data'))->render();
        // }
        if ($request->ajax()) {
            $category = $request->get('category');
            $location = $request->get('location');
            $distance = $request->get('distance');
            $latitude = $request->get('latitude');
            $longitude = $request->get('longitude');
            if (!empty($latitude) || !empty($longitude)) {
                $data = DB::table('services')
                    ->selectRaw("services.id AS serviceid,title,services.created_at,services.image AS image,description,sellers.id,price,latitude, longitude, SQRT(POW(69.1 * (latitude -  $latitude), 2) +POW(69.1 * ($longitude - longitude) * COS(latitude / 57.3), 2)) AS distance")
                    ->join('sellers', 'sellers.id', '=', 'services.seller_id')
                    ->when($category, function ($query, $category) {
                        $query->where('category_id', $category);
                    })
                //     // ->where('address', 'like', '%' . $location . '%')
                    ->groupBy('services.id')
                    ->when($distance, function ($query, $distance) {
                        $query->having('distance', '<', $distance);
                    })
                    ->orderBy('distance')
                    ->paginate(6);
            } else {
                $data = DB::table('services')
                    ->selectRaw("services.id AS serviceid,title,services.created_at,services.image AS image,description,sellers.id,price")
                    ->join('sellers', 'sellers.id', '=', 'services.seller_id')
                    ->when($category, function ($query, $category) {
                        $query->where('category_id', $category);
                    })
                    ->paginate(6);
            }
            return view('search_service', compact('data'))->render();
        }
    }

    public function service($title, $id)
    {
        $service = [];
        $service = Service::select('*', 'services.id AS serviceid', 'sellers.id AS sellersid', 'services.image as serviceimage')
            ->join('sellers', 'sellers.id', '=', 'services.seller_id')
            ->where("services.id", base64_decode($id))->first();
        $serviceimages = Serviceimage::where("service_id", base64_decode($id))->get();
        $review = Review::select('*', 'reviews.created_at AS created')->join("buyers", "buyers.id", "=", "reviews.buyer_id")
            ->where("service_id", base64_decode($id))->get();
        return view('service', [
            'title' => str_replace("-", " ", $title),
            'service' => $service,
            'serviceimages' => $serviceimages,
            'review' => $review,
        ]);
    }
}