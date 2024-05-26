<?php

namespace App\Filament\Resources\MproductResource\Pages;

use App\Filament\Resources\MproductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMproducts extends ListRecords
{
    protected static string $resource = MproductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
