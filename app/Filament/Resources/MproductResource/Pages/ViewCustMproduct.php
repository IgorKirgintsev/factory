<?php

namespace App\Filament\Resources\MproductResource\Pages;

use App\Filament\Resources\MproductResource;
use Filament\Actions;
use Filament\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\ImageEntry;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use App\Models\Morder;
use Filament\Forms;
use Filament\Forms\Components\Select;

class ViewCustMproduct extends ViewRecord
{

    protected static string $resource = MproductResource::class;
    protected static string $view = 'filament.pages.view-mproduct';



    protected function getHeaderActions(): array
    {



        return [


//  оформление
         Actions\CreateAction::make()
         ->button()
         ->color('success')
         ->label('Заказать')
         ->model(Morder::class)
         ->modalHeading('Создание заказа на изготовление изделия')
         ->modalSubmitActionLabel('Сохранить заказ')

         ->steps([
            Step::make('Данные заказчика')
            ->description('Введите фамилию и имя, адрес, телефон и почту')
            ->schema([
                TextInput::make('byname')
                  ->label('Фамилия Имя')
                  ->required(),
                TextInput::make('adress')
                  ->label('Адрес доставки')
                  ->required(),
                TextInput::make('telefon')
                  ->label('Телефон')
                  ->required(),
                TextInput::make('email')
                  ->label('Почта')
                  ->required(),


                  ])
             ->columns(2),
            Step::make('Описание деталей')
             ->description('Добавте описание деталей')
             ->schema([
                MarkdownEditor::make('info')
                   ->label('Описание'),
            ]),
            Step::make('Стоимость')
             ->description('Цена заказа')
             ->schema([
                TextInput::make('tsum')
                  ->label('Цена')
                  ->required(),
                TextInput::make('bysum')
                  ->label('Оплата')
                  ->required(),



            ]),
            Step::make('Доставка и готовность')
            ->description('Цена заказа')
            ->schema([

               Select::make('status')
                ->options([
                 'новый' => 'Новый заказ',
                 'в работе' => 'В работе',
                 'готов' => 'Готов',
                 ]),
                Forms\Components\DatePicker::make('redy_data')
                 ->required(),


           ]),



        ])

        ->mutateFormDataUsing(function (array $data): array {
            $data['mproduct_id'] = $this->record['id'];
            $data['nomer'] = 'зак-' . random_int(100000, 999999);
            $data['order_data'] = now();


            return $data;
        })

      ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name')
                 ->label(''),
                Section::make('Наше фото')
                 ->schema([
                 ImageEntry::make('image')
                 ->label('')
                 ->width('200%')
                 ->height('200%')
                ]),

                // ...
            ]);
    }



}
