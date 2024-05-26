<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MorderResource\Pages;
use App\Filament\Resources\MorderResource\RelationManagers;
use App\Models\Morder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\TextEntry;

class MorderResource extends Resource
{
    protected static ?string $model = Morder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Заказы';
    protected static ?string $modelLabel = 'Заказ';
    protected static ?string $pluralModelLabel = 'Заказы';
    protected static ?string $navigationGroup = 'Изделия';
    protected static ?int $navigationSort = 2;





    public static function form(Form $form): Form
    {
        return $form

        ->schema([
            Forms\Components\Section::make()
            ->columns(2)
            ->schema([
            Forms\Components\Select::make('mproduct_id')
                ->label('Изделие')
                ->relationship('mproduct','name')
                ->live()
                ->required(),
                Forms\Components\TextInput::make('byname')
                    ->label('Фамилия Имя')
                    ->required()
                    ->maxLength(255),
                ]),
                Forms\Components\Section::make()
                  ->columns(1)
                  ->schema([

                    Forms\Components\TextInput::make('adress')
                     ->label('Адрес доставки')
                     ->required()
                     ->maxLength(255),
                ]),
                Forms\Components\Section::make()
                 ->columns(2)
                ->schema([

                    Forms\Components\TextInput::make('telefon')
                     ->label('Телефон')
                     ->tel()
                     ->required()
                     ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                     ->label('Почта')
                     ->email()
                     ->required()
                     ->maxLength(255),
                ]),

                    Forms\Components\Textarea::make('info')
                     ->required()
                     ->maxLength(65535)
                     ->columnSpanFull(),

                Forms\Components\Section::make()
                  ->columns(2)
                  ->schema([

                    Forms\Components\TextInput::make('nomer')
                     ->required()
                     ->maxLength(10),
                    Forms\Components\DatePicker::make('order_data')
                     ->required(),
                    Forms\Components\TextInput::make('tsum')
                     ->required()
                     ->numeric(),
                    Forms\Components\TextInput::make('bysum')
                     ->required()
                     ->numeric(),
                ]),

                Forms\Components\Select::make('status')
                ->options([
                 'новый' => 'Новый заказ',
                 'в работе' => 'В работе',
                 'готов' => 'Готов',
                 ]),

                Forms\Components\DatePicker::make('redy_data')
                    ->required(),
            ]);


     }

    public static function table(Table $table): Table
    {
        return $table
          ->selectable()    //выбирать записи по галочке
           ->columns([
                Tables\Columns\TextColumn::make('mproduct.name')
                    ->label('Изделие')
                    ->size(TextColumn\TextColumnSize::Large)
                    ->sortable(),
                Tables\Columns\ImageColumn::make('mproduct.image')
                    ->label('фото'),
                Tables\Columns\TextColumn::make('nomer')
                    ->label('номер')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_data')
                    ->label('Дата')
                    ->date(),
                Tables\Columns\TextColumn::make('tsum')
                     ->label('Стоимость')
                     ->numeric(),
                Tables\Columns\TextColumn::make('bysum')
                    ->label('Оплата')
                    ->numeric(),
                    Tables\Columns\TextColumn::make('redy_data')
                    ->label('Готовность')
                    ->color('danger')
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                   ->label('Статус')
                //   ->options([
                //    'новый' => 'Новый',
                //    'в работе' => 'в работе',
                //    'готов' => 'Готов ',
                //   ]),
                   ->badge()
                   ->color(fn (string $state): string => match ($state) {
                       'новый' => 'gray',
                       'в работе' => 'warning',
                       'готов' => 'success',
                       }),
                Tables\Columns\TextColumn::make('byname')
                     ->label('Заказчик')
                     ->weight(FontWeight::Bold)
                     ->searchable(),
                Tables\Columns\TextColumn::make('adress')
                    ->label('Адрес')
                    ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('telefon')
                    ->label('Телефон')
                    ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('email')
                    ->label('Почта')
                    ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ])->defaultSort('created_at', 'desc')->persistSortInSession()   //сортировка

            ->filters([

                //
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
                              fn (Builder $query, $date): Builder => $query->whereDate('order_data', '>=', $date),
                                 )
                            ->when(
                               $data['dpo'] ?? null,
                              fn (Builder $query, $date): Builder => $query->whereDate('order_data', '<=', $date),
                                );
                          })
                         //
                      ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                   Tables\Actions\EditAction::make(),

                   Tables\Actions\Action::make('info')  // показ инфор листа
                   ->icon('heroicon-m-bars-3-bottom-right')
                   ->label('Информация')
                   ->modalSubmitAction(false)    // убрать кнопки
                   ->modalCancelAction(false)
                  ->infolist([
                    TextEntry::make('adress')
                     ->label('Адрес'),
                     TextEntry::make('telefon')
                     ->label('Телефон'),
                     TextEntry::make('email')
                     ->icon('heroicon-m-envelope')
                     ->label('Почта'),
                     TextEntry::make('created_at')
                     ->label('Создание'),
                    TextEntry::make('updated_at')
                      ->label('Изменение'),
                      ]),

                   ])
                ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
   //                 Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListMorders::route('/'),
            'create' => Pages\CreateMorder::route('/create'),
            'edit' => Pages\EditMorder::route('/{record}/edit'),
        ];
    }
}
