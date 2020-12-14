<?php

namespace App\Http\Controllers;

use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Burst;

use Illuminate\Support\Str;
use App\User;


class BurstController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }


    public function index()
    {
        // Get current user
        $user = User::findOrFail(auth()->user()->id);

        $reports = Burst::all();

        // $reports = $user->bursts()->orderBy('created_at', 'desc')->get();
        return view('burst.index')->with('reports', $reports);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('burst.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'location'     =>  'required',
            'filename'     =>  'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Get current user
        $user = User::findOrFail(auth()->user()->id);

        // get location
        $location = $request->input('location');

        // get description
        $desc = $request->input('description');

        $burst = new Burst();

        // check if image has been uploaded
        if ($request->has('filename')) {
            // get image file
            $image = $request->file('filename');

            $name=$image->getClientOriginalName();

            $image->move(public_path().'/images/', $name);  

            $filePath = '/images/'.$name;
            $burst->filename = $filePath;
            
        }

        
        $burst->location = $location;
        $burst->description = $desc;
        $user->bursts()->save($burst);
        // $burst->save();
        return redirect('/bursts')->with('success', 'Successfully uploaded complaint');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get current user
        $user = User::findOrFail(auth()->user()->id);

        $burst = $user->bursts()->find($id);
        return view('burst.edit')->with('burst', $burst);
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
        $request->validate([
            'location'     =>  'required',
            'filename'     =>  'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Get current user
        $user = User::findOrFail(auth()->user()->id);

        // get location
        $location = $request->input('location');

        // get description
        $desc = $request->input('description');

        $burst = $user->bursts()->find($id);

        // check if image has been uploaded
        if ($request->has('filename')) {
            // get image file
            $image = $request->file('filename');

            $name=$image->getClientOriginalName();

            $image->move(public_path().'/images/', $name);  

            $filePath = '/images/'.$name;
            $burst->filename = $filePath;
            
        }

        
        $burst->location = $location;
        $burst->description = $desc;
        $user->bursts()->save($burst);
        // $burst->save();
        return redirect('/bursts')->with('success', 'Successfully updated complaint');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail(auth()->user()->id);
        $burst = $user->bursts()->find($id);
        $burst->delete();
        return redirect()->back()->with('success', 'Successfully deleted complaint');
    }
}
