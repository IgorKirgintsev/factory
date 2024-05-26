<?php

namespace App\Filament\Resources\MproductResource\Pages;

use App\Filament\Resources\MproductResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\ImageEntry;
use App\Models\Morder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;


class ManMproduct extends Page  implements HasForms,  HasTable ,HasInfolists
{

    use InteractsWithRecord;
    use InteractsWithInfolists;
    use InteractsWithTable;
    use InteractsWithForms;


    protected static string $resource = MproductResource::class;

    protected static string $view = 'filament.resources.mproduct-resource.pages.man-mproduct';

    protected ?string $heading = 'Заказы по изделию';


    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }


     public function mproductinfolist(Infolist $infolist): Infolist
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
            ->query(Morder::query()->where('mproduct_id',$this->record->id))
            ->columns([
                TextColumn::make('byname'),
                TextColumn::make('nomer'),
                TextColumn::make('order_data')
                    ->date(),
                TextColumn::make('tsum')
                     ->numeric(),
                TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'новый' => 'gray',
                    'в работе' => 'warning',
                    'готов' => 'success',
                    })
                ])
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
