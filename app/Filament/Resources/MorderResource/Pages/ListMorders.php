<?php

namespace App\Filament\Resources\MorderResource\Pages;

use App\Filament\Resources\MorderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMorders extends ListRecords
{
    protected static string $resource = MorderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
