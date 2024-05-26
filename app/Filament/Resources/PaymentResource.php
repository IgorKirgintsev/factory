<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Grouping\Group;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Support\Facades\DB;


class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Оплата товаров';
    protected static ?string $modelLabel = 'Оплата товаров';
    protected static ?string $pluralModelLabel = 'Оплаты товаров';
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?int $navigationSort = 2;


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
                    ->live()
                    ->required(),
                Forms\Components\Select::make('order_id')
                    ->label('Продажи')
                    ->preload()
                  //  ->options(function (Get $get){
                  //      return Order::query()->where('client_id',$get('client_id'))->pluck('nomer','id');
                  //    })
                  ->options(function (Get $get){
                       return Order::select(DB::raw("CONCAT(nomer,' от ',order_data,' сумма ',tsum) AS full_nomer"),'id')->where('client_id',$get('client_id'))->get()->pluck('full_nomer','id');
                     })


                  ->required(),
                    ]),
                Forms\Components\Section::make()
                  ->columns(2)
                  ->schema([
                Forms\Components\Select::make('typ_doc')
                    ->label('Платежный документ')
                    ->options([
                     'Приходный кассовый ордер' => 'Приходный кассовый ордер',
                     'Платежное поручение' => 'Платежное поручение',
                     'Банковская карта' => 'Банковская карта',
                     ])
                    ->required(),
                Forms\Components\TextInput::make('metod')
                    ->required()
                    ->maxLength(30),
                    ]),
                Forms\Components\Section::make()
                  ->columns(3)
                  ->schema([
                Forms\Components\TextInput::make('nomer')
                    ->required()
                    ->maxLength(10),
                Forms\Components\DatePicker::make('pay_data')
                    ->date()
                    ->required(),
                Forms\Components\TextInput::make('psum')
                    ->default(0)
                    ->required()
                    ->placeholder('0.00')
                    ->numeric(),
                Forms\Components\Toggle::make('status')
                    ->required(),
                  ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->groups([
                Group::make('client.name')
                  ->label('Клиенты'),
                Group::make('pay_data')
                  ->label('Дата'),
                  ])


            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Клиент')
                    ->searchable(),
             //       ->sortable(),
                Tables\Columns\TextColumn::make('order.nomer')
                    ->label('Заказ'),
             //       ->sortable(),
                Tables\Columns\TextColumn::make('nomer')
                    ->label('Номер пл.док.'),
                Tables\Columns\TextColumn::make('pay_data')
                    ->label('Дата документа')
                    ->date(),
            //        ->sortable(),
                Tables\Columns\TextColumn::make('psum')
                     ->label('Сумма')
                     ->numeric(decimalPlaces: 2,decimalSeparator: '.',thousandsSeparator: ',')
                     ->sortable()
                     ->summarize(Sum::make()
                     ->label('Итого')
                     ->numeric(decimalPlaces: 2,decimalSeparator: '.',thousandsSeparator: ',')),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()

                    ->action(function($record,$column){
                        $name=$column->getName();
                        $record->update([
                           $name=> !$record->$name
                        ]);
                      }),

                Tables\Columns\TextColumn::make('typ_doc')
                     ->label('тип документа'),
                Tables\Columns\TextColumn::make('metod')
                    ->label('метод'),
              //  Tables\Columns\TextColumn::make('created_at')
              //      ->dateTime()
              //      ->sortable()
              //      ->toggleable(isToggledHiddenByDefault: true),
              //  Tables\Columns\TextColumn::make('updated_at')
              //      ->dateTime()
              //      ->sortable()
              //      ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('pay_data', 'desc')->persistSortInSession()

            ->filters([
                //
                Tables\Filters\Filter::make('pay_data')
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
                            fn (Builder $query, $date): Builder => $query->whereDate('pay_data', '>=', $date),
                        )
                        ->when(
                            $data['dpo'] ?? null,
                            fn (Builder $query, $date): Builder => $query->whereDate('pay_data', '<=', $date),
                        );
                   })


            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                  Tables\Actions\EditAction::make(),
                  Tables\Actions\ViewAction::make(),
                  Tables\Actions\Action::make('info')  // показ инфор листа
                   ->icon('heroicon-m-bars-3-bottom-right')
                   ->label('Инфо')
                   ->modalSubmitAction(false)    // убрать кнопки
                   ->modalCancelAction(false)
                   ->infolist([
                     TextEntry::make('created_at')
                      ->label('Создание'),

                     TextEntry::make('updated_at')
                      ->label('Изменение'),

                    ]),

                  ])



                ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
              //      Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            PaymentResource\Widgets\PaymentOverview::class,
        ];
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
            'view' => Pages\ViewPay::route('/{record}'),
        ];
    }
}
