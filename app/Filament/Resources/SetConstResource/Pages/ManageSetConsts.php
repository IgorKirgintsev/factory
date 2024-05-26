<?php

namespace App\Filament\Resources\SetConstResource\Pages;

use App\Filament\Resources\SetConstResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSetConsts extends ManageRecords
{
    protected static string $resource = SetConstResource::class;

    protected function getHeaderActions(): array
    {
        return [
         //   Actions\CreateAction::make(),
        ];
    }
}
