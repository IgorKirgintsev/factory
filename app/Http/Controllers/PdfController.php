<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Client;
use App\Models\MyCompany;


class PdfController extends Controller
{

    public function getPdf(Request $request)
    {

        $mcompany=MyCompany::find(1);

        $clients=Client::all();

        $data=[
            'title' => 'Список клиентов',
            'date'  => date('d.m.y'),
            'clients' => $clients,
            'mcompany' => $mcompany
           ];



       //       dd($data);
        //        return Pdf::loadView('pdf', ['record' => $client])
        //            ->stream($client->name .'.pdf');

        //        $pdf = Pdf::loadView('pdf', ['data' => $data]);

         //$pdf =  Pdf::loadView('pdf',compact('data'));
         $pdf =  Pdf::loadView('pdf',$data);
            $pdf->setPaper('A4', 'landscape');
         //     $pdf->setPaper('A4', 'portrait');
         return $pdf->stream();


    }
}
