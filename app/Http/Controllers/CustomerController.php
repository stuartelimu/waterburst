<?php
// Our Controller 
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;// This is important to add here. 
use App\Burst;

use PDF;
  
class CustomerController extends Controller
{
    public function printPDF()
    {
       // This  $data array will be passed to our PDF blade 
       $date = date('m');  
       $dataW = Burst::select('*')->whereMonth('created_at', $date)->get();

        $data = [
            'reports' => $dataW 
        ];
        
        $pdf = PDF::loadView('pdf_view', $data);  
        return $pdf->download('report.pdf');
    }
}