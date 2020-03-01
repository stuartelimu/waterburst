<?php

namespace App\Http\Controllers;
use App\Burst;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $reports = Burst::orderBy('created_at', 'desc')->paginate(6);
        return view('burst.index')->with('reports', $reports);
    }
}
