<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Fieldset;
use App\Filament\Pages\Settings;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;



    protected function getHeaderActions(): array
    {
       return [

        Actions\Action::make('Накладная')
        ->button()
 //       ->url(fn (): string => Settings::getUrl())
        ->url(fn(Order $record)=>route('order.pdf.download',$record))
        ->openUrlInNewTab(),

        Actions\Action::make('Счет')
        ->button(),



        Actions\Action::make('Оплаты_по_продаже')
        ->button()
        ->color('success')
        ->modalSubmitAction(false)        // убрать кнопки
        ->modalCancelAction(false)
        ->infolist([
         //   TextEntry::make('name'),
         //   TextEntry::make('client.email'),
         //   TextEntry::make('bodyorder.product.name'),
         //   TextEntry::make('bodyorder.bsum'),



               // оплата по заказу
         Fieldset::make('Оплаты')
         ->schema([
                TextEntry::make('payment.nomer')
                    ->label('номер')
                    ->listWithLineBreaks(),
                TextEntry::make('payment.pay_data')
                   ->label('дата')
                   ->date()
                   ->listWithLineBreaks(),
                TextEntry::make('payment.psum')
                   ->label('сумма')
                   ->listWithLineBreaks(),
                TextEntry::make('payment.typ_doc')
                   ->label('документ')
                   ->listWithLineBreaks(),
             ])->columns(4)





          ]),
        ];

    }

}
