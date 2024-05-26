<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use App\Models\Order;
use App\Models\SetConst;


class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

 //   protected function mutateFormDataBeforeSave(array $data): array
 //   {
 //       $data['tsum'] = 750;

 //       return $data;
 //   }

 protected function mutateFormDataBeforeCreate(array $data): array
 {
     $data['tsum'] = 0;

     return $data;
 }

    protected function getRedirectUrl(): string
    {
      $order =$this->record;

     return $this->getResource()::getUrl('edit',['record'=>$order]);

    }

    protected function afterCreate(): void
    {

         //запись последнего номера заказа
        $setconst = SetConst::find(1);
        $setconst->ordernum = SetConst::find(1)->ordernum+1;
        $setconst->save();

    }
}
