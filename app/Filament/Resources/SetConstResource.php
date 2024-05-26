<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SetConstResource\Pages;
use App\Filament\Resources\SetConstResource\RelationManagers;
use App\Models\SetConst;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Pages\Settings;


class SetConstResource extends Resource
{
    protected static ?string $model = SetConst::class;
   protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Настроки';
    protected static ?string $navigationGroup = 'Настройка';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Настройки';
    protected static ?string $pluralModelLabel = 'Настройки';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('status')
                ->label('Настройки')
                ->required()
                ->maxLength(20),// //
                Forms\Components\TextInput::make('ordernum')
                ->label('Номер заказа'),
                Forms\Components\TextInput::make('paynum')
                ->label('Номер оплаты'),





            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status')
                ->size(TextColumn\TextColumnSize::Large)
                 ->label('Настройки'),


                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),


            ])

             // вызов своей страницы по клику по записи
            ->recordUrl(function ($record) {

                // для мягко удаленных
            //     if($record->trashed()) {
            //         return null;
            //     }
                 return Settings::getUrl([$record]);
               })



            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSetConsts::route('/'),
        ];
    }
}
