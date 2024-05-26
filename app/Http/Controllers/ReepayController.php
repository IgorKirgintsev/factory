<?php

namespace App\Http\Controllers;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Seller;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use App\Models\Payment;
use App\Models\MyCompany;

use Illuminate\Http\Request;

class ReepayController extends Controller
{
    public  function download(Request $data)
    {

    if($data['client_id']>0)
    {
    $order=Payment::whereDate('pay_data', '>=', $data['ds'])
        ->whereDate('pay_data', '<=', $data['dpo'])
        ->where('status','=',$data['status'])
        ->where('client_id','=',$data['client_id'])
        ->where('client_id','=',$data['client_id'])
        ->orderBy('pay_data')
       ->get();
    }
    else
    {
        $order=Payment::whereDate('pay_data', '>=', $data['ds'])
        ->whereDate('pay_data', '<=', $data['dpo'])
        ->where('status','=',$data['status'])
        ->orderBy('pay_data')
       ->get();
    }


    $mcompany=MyCompany::find(1);

//    $company = new Party([
//        'name' => $mcompany->name,
//    ]);


   // формирование строк

   foreach($order as $body) {
    $items []= (new InvoiceItem())
      ->title($body->client->name)
      ->units($body->nomer)
      ->description($body->pay_data)
      ->subtotalprice($body->psum);
    }

  // формирование

   $invoice = Invoice::make('Реестр оплат')->template('reepay')
    ->buyer(new Party([]))
    ->currencySymbol('')
    ->addItems($items);

  // вывод
    return $invoice->stream();

    }

}
