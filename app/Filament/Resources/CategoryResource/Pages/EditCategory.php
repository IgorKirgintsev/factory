<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Product;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        // проверка перед удалением на наличие записей
        $order =$this->record;
        $isRecount =  Product::where('category_id', $order['id'])->count();


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
