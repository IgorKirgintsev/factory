<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\Order;
use App\Filament\Pages\Settings;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Pages\EditOrder as PagesEditOrder;
use Filament\Actions;
use Filament\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\EditOrder;
use Filament\Actions\ViewAction;
use App\Filament\Resources\OrderResource\Pages\ViewOrder;
use Filament\Resources\Components\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Get;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Seller;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;
use Filament\Forms\Components\Select;
use Illuminate\Http\Request;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

//    public ?array $data=[];

 //   use InteractsWithForms;

    protected function getHeaderActions(): array
    {

        return [
            Actions\CreateAction::make()->label('Новая продажа'),

            //  вызов модального окна и запуск отчета
            Actions\Action::make('Отчет')
            ->button()
            ->color('success')
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
                redirect()->route('reeord.pdf.download',$data);

            })

//                ->url(fn(array $data)=>route('reeord.pdf.download',$data))
//                ->openUrlInNewTab()

        ];

    }


    public function getTabs(): array   // вернее меню - фильтр
    {
        return [


            'Все' => Tab::make(),
            'Проведен' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', true)),
            'Не проведен' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', false)),






        ];  //
    }
}



