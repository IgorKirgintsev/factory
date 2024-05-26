<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\BodyOrder;
use App\Models\Order;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $order =$this->record;

      //  $data['tsum'] =  BodyOrder::where('order_id', $order['id'])->sum('bsum');
        $data['tsum'] =  Order::find($order->id)->bodyorder->sum('bsum');

        return $data;
    }

    protected function getHeaderActions(): array
    {

        $order =$this->record;
     //   $isRecount =  BodyOrder::where('order_id', $order['id'])->count();
        $isRecount =  Order::find($order->id)->bodyorder->count();  // использовать отношения

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
