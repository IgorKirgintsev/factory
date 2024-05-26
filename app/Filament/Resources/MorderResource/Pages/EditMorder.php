<?php

namespace App\Filament\Resources\MorderResource\Pages;

use App\Filament\Resources\MorderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMorder extends EditRecord
{
    protected static string $resource = MorderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
