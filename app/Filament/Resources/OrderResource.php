<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Client;
use App\Models\SetConst;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Carbon;
use Filament\Tables\Filters\SelectFilter;


class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Продажа товаров';
    protected static ?string $modelLabel = 'Продажа';
    protected static ?string $pluralModelLabel = 'Продажи';
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                 ->columns(2)
                 ->schema([
                    Forms\Components\Select::make('client_id')
                    ->label('Клиент')
                    ->relationship('client','name')
                    ->required()
                    ->preload(),

                  ]),
                Forms\Components\Section::make()
                   ->columns(3)
                   ->schema([
                  Forms\Components\TextInput::make('nomer')
                    ->label('Номер')
//                    ->default('зак-' . random_int(100000, 999999))
                     // номер заказа с нулями впереди
                    ->default('нак-' . str_pad(str(SetConst::find(1)->ordernum+1),5,'0',STR_PAD_LEFT))

                    ->required()
                    ->maxLength(10)
                    ->placeholder('1'),
                    Forms\Components\DatePicker::make('order_data')
                    ->label('Дата')
                    ->date()
                    ->default(now())
                    ->required(),
                    Forms\Components\Toggle::make('status')
                    ->label('статус')
                    ->required(),

                  ])

                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->selectable()    //выбирать записи по галочке

        // группировка по меню
           ->groups([
               Group::make('client.name')
                ->label('Клиенты'),
               Group::make('order_data')
              ->label('Дата'),
                ])


            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Клиент')
                //    ->sortable()
                    ->searchable(),
                    Tables\Columns\TextColumn::make('nomer')
                    ->label('номер'),
                Tables\Columns\TextColumn::make('order_data')
                    ->label('Дата')
                    ->date(),
                 //   ->sortable(),
                Tables\Columns\TextColumn::make('tsum')
                    ->label('Сумма')
                    ->numeric(decimalPlaces: 2,decimalSeparator: '.',thousandsSeparator: ',')
                //    ->sortable()
                    ->summarize(Sum::make()
                       ->label('Итого')
                       ->numeric(decimalPlaces: 2,decimalSeparator: '.',thousandsSeparator: ',')),

                Tables\Columns\IconColumn::make('status')
                    ->label('Статус')
                    ->boolean()
                    ->action(function($record,$column){
                      $name=$column->getName();
                      $record->update([
                      $name=> !$record->$name
                      ]);
                    }),

                //    Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->toggleable(isToggledHiddenByDefault: false),
                //    Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->toggleable(isToggledHiddenByDefault: false),

                 ])->defaultSort('created_at', 'desc')->persistSortInSession()

            ->filters([

                Tables\Filters\Filter::make('order_data')
                    ->form([
                        Forms\Components\DatePicker::make('ds')
                            ->label('Дата с')
                            ->default(date('Y-m-01')),
                        Forms\Components\DatePicker::make('dpo')
                            ->label('Дата по')
                            ->default(now()),
                         ])
                        ->query(function (Builder $query, array $data): Builder {
                          return $query
                          ->when(
                                $data['ds'] ?? null,
                                fn (Builder $query, $data): Builder => $query->whereDate('order_data', '>=', $data)
                            )
                            ->when(
                                $data['dpo'] ?? null,
                                fn (Builder $query, $data): Builder => $query->whereDate('order_data', '<=', $data)
                            );

                        }),

                        SelectFilter::make('client_id')
                           ->label('Клиенты')
                           ->options(Client::pluck('name','id')),



                    ])



                // меню действий
             ->actions([
                Tables\Actions\ActionGroup::make([
                  Tables\Actions\ViewAction::make(),
                  Tables\Actions\EditAction::make(),

                  Tables\Actions\Action::make('info')  // показ инфор листа
                      ->icon('heroicon-m-bars-3-bottom-right')
                      ->label('Информация по продаже')
                      ->modalSubmitAction(false)    // убрать кнопки
                      ->modalCancelAction(false)
                     ->infolist([
                       TextEntry::make('created_at')
                        ->label('Создание продажи'),
                       TextEntry::make('updated_at')
                         ->label('Изменение продажи'),
                    ]),
                  ])
                  ->label('')         // настройка меню действий
                  ->icon('heroicon-m-ellipsis-vertical')
                  ->size('ActionSize::Small')
                  ->color('primary')
                  ->dropdownPlacement('top-start')
                  //->button()
                ])



                 ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                 //   Tables\Actions\DeleteBulkAction::make(),
                ]),
             ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BodyOrderRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}/view}'),
        ];
    }
}
