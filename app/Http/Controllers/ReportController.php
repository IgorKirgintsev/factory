<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{

    public function ReportPdf(Request $data)
    {
        //dd($data['ds']);

         $pdf =  Pdf::loadView('report21');
         $pdf->setPaper('A4', 'landscape');
         //     $pdf->setPaper('A4', 'portrait');
         return $pdf->stream();


    }

}
