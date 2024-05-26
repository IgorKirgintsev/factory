<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\BodyOrder;



class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {

            // проверка перед удалением на наличие записей
            $order =$this->record;
            $isRecount =  BodyOrder::where('product_id', $order['id'])->count();


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
