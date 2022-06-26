<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Auth;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Faq::all()->where('admin_id', Auth::user()->id);
        return view('admin.faq.list', ['faqs' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq.create');
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
            'question' => ['required', 'max:255'],
            'answer' => ['required', 'max:255'],
        ]);
        //    insert
        $response = Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'admin_id' => Auth::user()->id,
        ]);
        if ($response) {
            return redirect()->route('admin.faq.new')->with('success', 'Data is saved succesfully');
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
        return view('admin.faq.edit', ['faq' => Faq::find($id)]);
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
            'question' => ['required', 'max:255'],
            'answer' => ['required', 'max:255'],
        ]);

        $response = Faq::whereId($id)->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'admin_id' => Auth::user()->id,
        ]);
        if ($response) {
            return redirect()->route('admin.faq.edit', $id)->with('success', 'Data is updated succesfully');
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
        $response = Faq::findOrFail($id)->delete();
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