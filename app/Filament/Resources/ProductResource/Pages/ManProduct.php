<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\ImageEntry;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use App\Models\BodyOrder;



class ManProduct extends Page  implements HasInfolists,HasForms, HasTable
{

    use InteractsWithRecord;
    use InteractsWithInfolists;
    use InteractsWithTable;
    use InteractsWithForms;

    protected static string $resource = ProductResource::class;

    protected static string $view = 'filament.resources.product-resource.pages.man-product';

    protected ?string $heading = 'История продаж';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function productinfolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->record($this->record)
        ->schema([
                TextEntry::make('name')
                ->label('')
                ->size(TextEntry\TextEntrySize::Large)
               ->weight(FontWeight::Bold)
               ->color('warning')
               ->bulleted(),

               ImageEntry::make('image')
               ->label('')
               ->height(100)
               ->square()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(BodyOrder::query()->where('product_id',$this->record->id))
            ->columns([

                TextColumn::make('order.order_data'),

                TextColumn::make('order.nomer'),

                TextColumn::make('order.client.name'),

                TextColumn::make('price'),

                TextColumn::make('kol'),

            ])->defaultSort('created_at', 'desc')->persistSortInSession()

             ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }



}
