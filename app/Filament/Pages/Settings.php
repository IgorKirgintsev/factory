<?php

namespace App\Filament\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Forms\Components\Actions;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Client;
use App\Models\MyCompany;




class Settings extends Page implements HasForms
{

    use InteractsWithForms;

    public ?array $data=[];

    protected static ?string $navigationIcon ='heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Отчет по продажам';
    protected static string $view = 'filament.pages.settings';
    protected static ?string $navigationBadgeTooltip = 'Отчет';
    protected ?string $maxContentWidth = 'full';
    protected ?string $heading = 'Отчет по продажам';
    protected static ?string $navigationGroup = 'Отчеты';
    protected static ?int $navigationSort = 2;

    public function mount(){
        $this->form->fill();
    }

    public function form(Form $form):Form{
        return $form->schema([

          Forms\Components\Section::make()
            ->description('Дата')
            ->columns(2)
            ->schema([
               Forms\Components\DatePicker::make('ds')
                 ->label('Дата с')
                ->default(date('Y-m-01')),
               Forms\Components\DatePicker::make('dpo')
                  ->label('Дата по')
                ->default(now()),
            ]),


            Forms\Components\Select::make('client_id')
              ->label('Клиент')
               ->options(Client::pluck('name','id')),



        ])->statePath('data');


    }

    public function getFormActions() {
         return[
            Action::make('pdf')
         ];

    }


    public function getReport()
    {

        redirect()->route('reportpdf',$this->data);

    }

}




