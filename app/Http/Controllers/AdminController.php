<?php

namespace App\Http\Controllers;
use App\Burst;
use Illuminate\Http\Request;
use App\Charts\BurstChart;

use Charts;
use App\User;
use DB;
use FarhanWazir\GoogleMaps\GMaps;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index() {

        $months = [];
        $values = [];
        // $users = Burst::with('user')->whereMonth('created_at', date('m'))
        //     ->whereYear('created_at', date('Y'))
        //     ->get();
            
        $bursts = Burst::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))->whereYear('created_at', date('Y'))->groupBy('monthname')->get();

        // foreach($bursts as $burst) {
        //     $months[] = $burst->monthname;
        //     $values[] = $burst->count;
        // }

        // get month wise reports
        User::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get(['name','created_at']);

        $data = Burst::select(DB::raw("(COUNT(*)) as count"),'location')
            ->groupBy('location')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)
            ->get();

        foreach($data as $dt) {
            $months[] = $dt->location;
            $values[] = $dt->count;
        }

        // $users = $users->values();

        // $data = User::groupBy('name')
        //     ->get()
        //     ->map(function ($item) {
        //         return count($item);
        //     });

        // $chart = new SampleChart;
        // $chart->labels($data->keys());
        // $chart->dataset('My dataset', 'line', $data->values());

        $burstChart = new BurstChart;
        $burstChart->labels($months);
        $burstChart->dataset('Bursts', 'bar', $values);

        // $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))->get();
        
        // $burstChart = Charts::database($users, 'bar', 'highcharts')
		// 	      ->title("Monthly new Register Users")
		// 	      ->elementLabel("Total Users")
		// 	      ->dimensions(1000, 500)
		// 	      ->responsive(false)
		// 	      ->groupByMonth(date('Y'), true);

        
        $reports = Burst::with('user')->get();
        return view('admin.index', ['reports' => $reports, 'burstChart' => $burstChart, 'users' => $data]);
    }

    public function map() {

        $config['center'] = 'Sydney Airport,Sydney';
        $config['zoom'] = '14';
        $config['map_height'] = '400px';

        $gmap = new GMaps();
        $gmap->initialize($config);
     
        $map = $gmap->create_map();
        return view('admin.map', ['map'=> $map]);
    }
}
