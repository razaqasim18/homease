<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Auth;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Blog::all();
        return view('admin.blog.list', ['blogs' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
            'content' => ['required', 'max:1000'],
            'image' => ['required', 'mimes:jpg,jpeg,png'],
        ]);

        // $name = $request->file('image')->getClientOriginalName();

        // $path = $request->file('image')->store('public/uploads');

        $fileName = time() . '.' . $request->file('image')->extension();
        if ($request->file('image')->move(public_path('uploads/blog'), $fileName)) {

            $response = Blog::create([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $fileName,
                'admin_id' => Auth::user()->id,
            ]);
            if ($response) {
                return redirect()->route('admin.blog.new')->with('success', 'Data is saved succesfully');
            } else {
                return back()->withInput()->with('error', 'Something went wrong');
            }
        } else {
            return back()->withInput()->with('error', 'Something went wrong');
        }
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
        return view('admin.blog.edit', ['blog' => Blog::findorfail($id)]);
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
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
            'content' => ['required', 'max:1000'],
        ]);
        $fileName = '';

        if (!empty($request->file('image'))) {
            $validatedData = $request->validate([
                'image' => ['required', 'mimes:jpg,jpeg,png'],
            ]);
            $fileName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/blog'), $fileName);
        } else {
            // $name = $request->file('image')->getClientOriginalName();
            // $path = $request->file('image')->store('public/uploads');
            $fileName = $request->showimage;
        }

        if (!empty($fileName)) {
            $response = Blog::findOrFail($id)->update([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $fileName,
                'admin_id' => Auth::user()->id,
            ]);
            if ($response) {
                return redirect()->route('admin.blog.edit', $id)->with('success', 'Data is updated succesfully');
            } else {
                return back()->withInput()->with('error', 'Something went wrong');
            }
        } else {
            return back()->withInput()->with('error', 'Something went wrong');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Blog::findOrFail($id)->delete();
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