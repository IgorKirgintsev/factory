<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use Filament\Pages\Concerns\ExposesTableToWidgets;
use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;

class ListPayments extends ListRecords
{

//    public static string $resource = PaymentResource::class;

    use ExposesTableToWidgets;

    public static string $resource = PaymentResource::class;

    protected function getHeaderWidgets(): array
    {
        return PaymentResource::getWidgets();
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Новая оплата'),


            //  вызов модального окна и запуск отчета
            Actions\Action::make('Отчет')
            ->button()
            ->form([
                Forms\Components\DatePicker::make('ds')
                   ->label('Дата')
                   ->default(date('Y-m-01'))
                   ->date(),   // ...
                Forms\Components\DatePicker::make('dpo')
                   ->label('Дата')
                   ->default(now())
                   ->date(),
                   Forms\Components\Toggle::make('status')
                   ->label('статус'),

                   Forms\Components\Select::make('client_id')
                   ->label('Клиент')
                   ->relationship('client','name'),

               ])

               ->modalSubmitActionLabel('Формировать')
               ->modalCancelAction(false)

               ->action(function (array $data) {
                redirect()->route('reepay.pdf.download',$data);

            })



        ];
    }
}
