<?php

namespace App\Filament\Resources\MorderResource\Pages;

use App\Filament\Resources\MorderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMorder extends CreateRecord
{
    protected static string $resource = MorderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
