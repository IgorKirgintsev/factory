<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Order;

class EditClient extends EditRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {

        $order =$this->record;
        $isRecount =  Order::where('client_id', $order['id'])->count();


       if ($isRecount>0)
        {

          return [];
        }
        else
        {

          return [
              Actions\DeleteAction::make(),
             ];

         }

    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
