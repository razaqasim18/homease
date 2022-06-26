<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Serviceimage;
use Auth;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Service::select('*', 'services.id AS servicesid')
            ->join('categories', 'categories.id', '=', 'services.category_id')
            ->where("seller_id", Auth::guard('seller')->user()->id)
            ->get();
        return view('seller.service.list', ['services' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('seller.service.create', [
            'category' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = explode(",", Auth::guard('seller')->user()->location);
        $fileName = time() . '.' . $request->file('image')->extension();
        $service = new Service;
        $service->seller_id = Auth::guard('seller')->user()->id;
        $service->category_id = $request->category;
        $service->title = $request->title;
        if ($request->file('image')->move(public_path('uploads/service'), $fileName)) {
            $service->image = $fileName;
        }
        $service->description = $request->description;
        $service->price = $request->price;
        $service->address = Auth::guard('seller')->user()->address;
        $service->latitude = $location['0'];
        $service->longitude = $location['1'];
        $service->save();
        $serviceid = $service->id; // this give us the last inserted record id
        if ($serviceid) {
            $result = ['type' => 1, 'serviceid' => $serviceid];
        } else {
            $type = 0;
            $result = ['type' => 0, 'msg' => 'Something went wrong'];
        }
        echo json_encode($result);
        exit;
    }

    public function storeImage(Request $request)
    {
        if ($request->hasfile('file')) {
            $i = 1;
            foreach ($request->file('file') as $file) {
                // $name = $file->getClientOriginalName();
                $name = time() . $i++ . '.' . $file->extension();
                $file->move(public_path('uploads/service'), $name);
                $imgData[] = $name;

                $fileModal = new Serviceimage();
                $fileModal->image = $name;
                $fileModal->service_id = $request->serviceid;

                $fileModal->save();
            }
            echo json_encode(['type' => 1, 'msg' => "Data saved successfully"]);
            exit;
        }
        // if ($image = $request->file('file')) {
        //     foreach ($image as $files) {
        //         $destinationPath = 'public/uploads/service/'; // upload path
        //         $profileImage = time() . "." . $files->getClientOriginalExtension();
        //         $files->move($destinationPath, $profileImage);
        //         $insert['image'] = $profileImage;
        //         $insert['service_id'] = $request->serviceid;
        //     }
        //     $check = Serviceimage::create($insert);
        // }
        // var_dump($insert);

        // response()->json(['type' => 1, 'msg' => "success"]);
        // if ($request->file('file')) {
        //     $img = $request->file('file');
        //     //here we are geeting userid alogn with an image
        //     $userid = $request->userid;
        //     $imageName = strtotime(now()) . rand(11111, 99999) . '.' . $img->getClientOriginalExtension();
        //     $user_image = new Serviceimage();
        //     $original_name = $img->getClientOriginalName();
        //     $user_image->image = $imageName;
        //     if (!is_dir(public_path() . '/uploads/service/')) {
        //         mkdir(public_path() . '/uploads/service/', 0777, true);
        //     }
        //     $request->file('file')->move(public_path() . '/uploads/service/', $imageName);
        //     // we are updating our image column with the help of user id
        //     $user_image->where('id', $userid)->update(['image' => $imageName]);
        //     return response()->json(['status' => "success", 'imgdata' => $original_name, 'userid' => $userid]);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::all();
        $service = Service::findorfail($id);
        $serviceimage = Serviceimage::where('service_id', $id)->get();

        return view('seller.service.edit', [
            'category' => $category,
            'service' => $service,
            'serviceimage' => $serviceimage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!empty($request->file('image'))) {
            $fileName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/service'), $fileName);
        } else {
            $fileName = $request->showimage;
        }
        $location = explode(",", Auth::guard('seller')->user()->location);
        $service = Service::find($id);
        // $service->seller_id = Auth::guard('seller')->user()->id;
        $service->category_id = $request->category;
        $service->title = $request->title;
        $service->image = $fileName;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->address = Auth::guard('seller')->user()->address;
        $service->latitude = $location['0'];
        $service->longitude = $location['1'];
        $service->save();
        $serviceid = $service->id; // this give us the last inserted record id
        if ($serviceid) {
            $result = ['type' => 1, 'serviceid' => $serviceid];
        } else {
            $type = 0;
            $result = ['type' => 0, 'msg' => 'Something went wrong'];
        }
        echo json_encode($result);
        exit;
    }

    public function storeUpdateImage(Request $request)
    {
        if ($request->hasfile('file')) {
            $i = 1;
            foreach ($request->file('file') as $file) {
                if (Serviceimage::where('service_id', '=', $request->serviceid)->count() >= 5) {
                    echo json_encode(['type' => 0, 'msg' => "Max value 5 reached"]);
                    exit;
                }
                // $name = $file->getClientOriginalName();
                $name = time() . $i++ . '.' . $file->extension();
                $file->move(public_path('uploads/service'), $name);
                $imgData[] = $name;

                $fileModal = new Serviceimage();
                $fileModal->image = $name;
                $fileModal->service_id = $request->serviceid;

                $fileModal->save();
            }
            echo json_encode(['type' => 1, 'msg' => "Data saved successfully"]);
            exit;
        }
        // if ($image = $request->file('file')) {
        //     foreach ($image as $files) {
        //         $destinationPath = 'public/uploads/service/'; // upload path
        //         $profileImage = time() . "." . $files->getClientOriginalExtension();
        //         $files->move($destinationPath, $profileImage);
        //         $insert['image'] = $profileImage;
        //         $insert['service_id'] = $request->serviceid;
        //     }
        //     $check = Serviceimage::create($insert);
        // }
        // var_dump($insert);

        // response()->json(['type' => 1, 'msg' => "success"]);
        // if ($request->file('file')) {
        //     $img = $request->file('file');
        //     //here we are geeting userid alogn with an image
        //     $userid = $request->userid;
        //     $imageName = strtotime(now()) . rand(11111, 99999) . '.' . $img->getClientOriginalExtension();
        //     $user_image = new Serviceimage();
        //     $original_name = $img->getClientOriginalName();
        //     $user_image->image = $imageName;
        //     if (!is_dir(public_path() . '/uploads/service/')) {
        //         mkdir(public_path() . '/uploads/service/', 0777, true);
        //     }
        //     $request->file('file')->move(public_path() . '/uploads/service/', $imageName);
        //     // we are updating our image column with the help of user id
        //     $user_image->where('id', $userid)->update(['image' => $imageName]);
        //     return response()->json(['status' => "success", 'imgdata' => $original_name, 'userid' => $userid]);
        // }
    }

    public function destroy($id)
    {
        $response = Service::findOrFail($id)->delete();
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

    public function destroyImages($id)
    {
        $response = Serviceimage::findOrFail($id)->delete();
        if ($response) {
            $type = 1;
            $msg = 'Image is deleted successfully';
        } else {
            $type = 0;
            $msg = 'Something went wrong';
        }
        $result = ['type' => $type, 'msg' => $msg];
        echo json_encode($result);
        exit;
    }

}