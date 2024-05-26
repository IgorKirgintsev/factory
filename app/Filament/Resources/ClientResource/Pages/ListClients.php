<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Client;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Mail;




class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('pdf')
               ->label('Печать PDF')
               ->color('success')
           //    ->url(fn (Client $record) => route('pdf', $record))
               ->url(fn () => route('pdf'))
               ->openUrlInNewTab(),




            ];
    }
}
