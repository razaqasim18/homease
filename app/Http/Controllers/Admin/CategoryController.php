<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Category::all();
        return view('admin.category', ['categorys' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = $request->category;
        $error = '';
        if (empty($category)) {
            $error = "Category is required" . "\n";
        } else {
            if (Category::where('category', $category)->exists()) {
                $error = "Category already exits" . "\n";
            }
        }
        if (!empty($error)) {
            $result = ['type' => 0, 'msg' => $error];
            echo json_encode($result);
            exit;
        }
        $response = Category::create([
            'category' => $category,
        ]);
        if ($response) {
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
    {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = $request->category;
        $error = '';
        if (empty($category)) {
            $error = "Category is required" . "\n";
        } else {
            if (Category::where('category', '=', $category)->where('id', '!=', $id)->exists()) {
                $error = "Category already exits" . "\n";
            }
        }
        if (!empty($error)) {
            $result = ['type' => 0, 'msg' => $error];
            echo json_encode($result);
            exit;
        }

        $response = Category::findOrFail($id)->update([
            'category' => $category,
        ]);
        if ($response) {
            $type = 1;
            $msg = 'Data is udpated successfully';
        } else {
            $type = 0;
            $msg = 'Something went wrong';
        }
        $result = ['type' => $type, 'msg' => $msg];
        echo json_encode($result);
        exit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Category::findOrFail($id)->delete();
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
}