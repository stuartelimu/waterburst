<?php

namespace App\Http\Controllers;
use App\Burst;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index() {
        $reports = Burst::with('user')->get();
        return view('admin.index')->with('reports', $reports);
    }
}
