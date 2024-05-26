<?php

namespace App\Http\Controllers;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Seller;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MyCompany;
use App\Filament\Resources\OrderResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Filament\Actions;
use Filament\Forms;


class ReeorderController extends Controller
{

//    protected static ?string $model = Order::class;
//    protected static ?string $collection   = OrderResource::class;


    public  function download(Request $data)
    {

    if($data['client_id']>0)
    {
    $order=Order::whereDate('order_data', '>=', $data['ds'])
        ->whereDate('order_data', '<=', $data['dpo'])
        ->where('status','=',$data['status'])
        ->where('client_id','=',$data['client_id'])
        ->where('client_id','=',$data['client_id'])
        ->orderBy('order_data')
       ->get();
    }
    else
    {
        $order=Order::whereDate('order_data', '>=', $data['ds'])
        ->whereDate('order_data', '<=', $data['dpo'])
        ->where('status','=',$data['status'])
        ->orderBy('order_data')
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
      ->description($body->order_data)
      ->subtotalprice($body->tsum);
    }

  // формирование

   $invoice = Invoice::make('Реестр заказов')->template('reedef')
    ->buyer(new Party([]))
    ->currencySymbol('')
    ->addItems($items);

  // вывод
    return $invoice->stream();

    }

}
