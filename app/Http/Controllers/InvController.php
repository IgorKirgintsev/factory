<?php

namespace App\Http\Controllers;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Seller;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Client;
use App\Models\MyCompany;
use App\Models\BodyOrder;
use \NumberFormatter;


class InvController extends Controller
{

    public function download(Order $order)
    {

//      так не надо делать
//      $order=Order::find($record->id);
//      $client=Client::find($order->client_id);
//      dd($order->id);
//      $client=$order->client;
//      $bodyorder=BodyOrder::where('order_id',$order->id)->get();
//      $bodyorder=Order::find($record->id)->bodyorder;   // используя связь


    $mcompany=MyCompany::find(1);

    $company = new Party([
        'name'          => $mcompany->name,
        'address'       => $mcompany->adress,
        'code'          => $mcompany->inn,
        'email'         => $mcompany->email,
        'phone'         => '92156737873',
        'director'      => 'Петров  А В',

        'custom_fields' => [

       ],
    ]);


    $customer = new Party([
      'name'          => $order->client->name,
      'address'       => $order->client->adres,
      'code'          => $order->client->inn,
      'email'         => $order->client->email,
      'phone'         => $order->client->telefon,
      'director' => 'Иванов B B',

      'custom_fields' => [

       ],


    ]);

   // формирование строк

   foreach($order->bodyorder as $body) {
    $items []= (new InvoiceItem())
      ->title($body->product->name)
      ->units($body->product->ed)
      ->pricePerUnit($body->price)
      ->quantity($body->kol);

  }


  // формирование накладной

   $invoice = Invoice::make('Заказ')->template('invdef')
    ->serialNumberFormat($order->nomer)
    ->dateFormat($order->order_data)
    ->seller($company)
    ->buyer($customer)
    ->currencySymbol('')
    ->currencyCode('RUB')
    ->payUntilDays(14)
    ->setCustomData(str_price($order->tsum))
    ->addItems($items);

 //      ->discountByPercent(10)
//    ->taxRate(15)
//    ->shipping(1.99)

  // вывод
    return $invoice->stream();

    }   //
}

// Сумма прописью.
function str_price($value)
{
	$value = explode('.', number_format($value, 2, '.', ''));

	$f = new NumberFormatter('ru', NumberFormatter::SPELLOUT);
	$str = $f->format($value[0]);

	// Первую букву в верхний регистр.
	$str = mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1, mb_strlen($str));

	// Склонение слова "рубль".
	$num = $value[0] % 100;
	if ($num > 19) {
		$num = $num % 10;
	}
	switch ($num) {
		case 1: $rub = 'рубль'; break;
		case 2:
		case 3:
		case 4: $rub = 'рубля'; break;
		default: $rub = 'рублей';
	}

	return $str . ' ' . $rub . ' ' . $value[1] . ' копеек.';
}
/////////////////////////////////////////////////////////////////////////////////////////
