<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MyCompanyResource\Pages;
use App\Filament\Resources\MyCompanyResource\RelationManagers;
use App\Models\MyCompany;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;


class MyCompanyResource extends Resource
{
    protected static ?string $model = MyCompany::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Наше предпритие';
    protected static ?string $navigationGroup = 'Настройка';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Наше предприятие';
    protected static ?string $pluralModelLabel = 'Наше предприятие';




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                     ->label('Название предприятия')
                     ->required()
                     ->maxLength(255),//
                Forms\Components\TextInput::make('inn')
                     ->label('Инн')
                     ->required()
                     ->maxLength(255),//
                Forms\Components\TextInput::make('adress')
                     ->label('Адрес')
                     ->required()
                     ->maxLength(255),//
                Forms\Components\TextInput::make('director')
                     ->label('Директор')
                     ->required()
                     ->maxLength(255),//
                Forms\Components\TextInput::make('email')
                     ->label('Почта')
                     ->required()
                     ->maxLength(255),
                Forms\Components\TextInput::make('bank')
                     ->label('Банк')
                     ->required()
                     ->maxLength(255),
                     Forms\Components\Section::make('Изображение')
                     ->schema([
                Forms\Components\FileUpload::make('image')
                     ->label('Фото')
                     ->image()


                    ])

                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->size(TextColumn\TextColumnSize::Large)
                 ->label('Название предприятия'),
                Tables\Columns\TextColumn::make('inn')
                 ->label('Инн'),
                Tables\Columns\TextColumn::make('adress')
                 ->label('Адрес'),
                Tables\Columns\TextColumn::make('director')
                 ->searchable()
                 ->label('Директор'),
                Tables\Columns\TextColumn::make('email')
                 ->label('Почта'),
                Tables\Columns\TextColumn::make('bank')
                 ->label('Банк'),

             ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
              //  Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                //    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMyCompanies::route('/'),
        ];
    }
}
