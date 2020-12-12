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
        $locations = [];


        $config = array();
        $config['center'] = '0.347596, 32.582520';
        // $config['zoom'] = '14';
        $config['map_height'] = '80vh';

        $gmap = new GMaps();
        $gmap->initialize($config);

        $data = Burst::select(DB::raw("(COUNT(*)) as count"),'location')
            ->groupBy('location')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)
            ->get();

        foreach($data as $dt) {
            // $locations[] = $dt->location;
            $marker['position'] = '0.3475, 32.64917';
            $gmap->add_marker($marker);
        }

        

     
        $map = $gmap->create_map();
        return view('admin.map', ['map'=> $map]);
    }

    public function customers() {

        $customers = User::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
        ->whereYear('created_at', date('Y'))
        ->groupBy('monthname')
        ->get();

        $users = User::where('role', '!=', 'admin')->get();

        
        
        // $user = User::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        // ->groupBy('year', 'month')
        // ->orderBy('year', 'desc')
        // ->get();

        $user = User::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
        ->whereBetween('created_at', array('2020-01-01','2020-12-31'))
        ->whereYear('created_at', date('Y'))
        ->groupBy('monthname')
        ->get();
        // $user = "aa";

        $months = [];
        $values = [];

        foreach($customers as $customer) {
            $months[] = $customer->monthname;
            $values[] = $customer->count;
        }

        $customerChart = new BurstChart;
        $customerChart->labels($months);
        $customerChart->dataset('Customers', 'line', $values);

        return view('admin.customers', ['users' => $users,'cust'=>$user, 'customers'=>$customers, 'customerChart' => $customerChart]);

    }
}
