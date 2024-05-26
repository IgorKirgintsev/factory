<?php

namespace App\Filament\Pages;

use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Tabs;
use App\Models\MyCompany;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Главная страница';
    protected static string $view = 'filament.pages.dashboard';

    public function dashboardInfolist(Infolist $infolist): Infolist
    {

        $mcompany=MyCompany::find(1);

        return $infolist
 //       ->record($mcompany)
        ->state([
            'name' => 'Производство изделий',
            'mcompany' =>$mcompany,

        ])

        ->schema([
            Section::make('Предприятие')
             ->description('Изготовление металлоконструкций')
             ->schema([
              TextEntry::make('name')
               ->size(TextEntry\TextEntrySize::Large)
               ->weight(FontWeight::Bold)
               ->label(' '),
              TextEntry::make('mcompany.name')
               ->label('Предприятие')
               ->color('primary')
               ->size(TextEntry\TextEntrySize::Large),
              TextEntry::make('mcompany.email')
               ->label('Почта')
               ->icon('heroicon-m-envelope')
               ->iconColor('primary'),
             ]),
              // ...
            Section::make('Наше фото')
             // ->description('Изготовление металлоконструкций')
              ->schema([
              ImageEntry::make('mcompany.image')
              ->label('Газель')
           //   ->width(600)
           //   ->height(400)
            //  ->size(40),

        ]),


              Tabs::make('Tabs')
               ->tabs([
               Tabs\Tab::make('Контакты')
                ->schema([
                  TextEntry::make('mcompany.name')
                  ->label('Предприятие')
                  ->color('primary')
                  ->size(TextEntry\TextEntrySize::Large),            // ...
                  TextEntry::make('mcompany.adress')
                  ->label('Адрес')
                  ->color('primary')
                  ->size(TextEntry\TextEntrySize::Small),            // ...
                ]),
              Tabs\Tab::make('Наши изделия')
                ->schema([
                  TextEntry::make('mcompany.name')
                  ->label('Изделия')
                  ->color('primary')
                  ->size(TextEntry\TextEntrySize::Small),            // ...
                     // ...
                  ]),
              Tabs\Tab::make('Документы')
                ->schema([
                  TextEntry::make('mcompany.director')
                  ->label('Связь')
                  ->color('primary')
                  ->size(TextEntry\TextEntrySize::Small),

                  // ...
                  ]),
              ])

            ]);




    }






}
