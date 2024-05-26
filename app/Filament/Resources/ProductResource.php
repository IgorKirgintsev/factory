<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Category;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Filters\SelectFilter;




class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Товары, Материалы';
    protected static ?string $modelLabel = 'Товары, Материалы';
    protected static ?string $pluralModelLabel = 'Товары, Материалы';
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?int $navigationSort = 3;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->label('Категория')
                    ->relationship('category','name')
                   ->required()
                   ->preload(),
                Forms\Components\TextInput::make('name')
                   ->label('Наименование')
                   ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ed')
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('price')
                    ->label('Цена')
                    ->numeric(2,'.',',')
                    ->inputMode('decimal'),
                    Forms\Components\MarkdownEditor::make('info')
                    ->columnSpan('full'),

                    Forms\Components\Section::make('Изображение')
                     ->schema([
                        Forms\Components\FileUpload::make('image')
                          ->label('Фото')
                          ->image()


                    ])
                    ->collapsible(),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->groups([
            Group::make('category.name')
                ->label('Категория'),
        ])
        ->defaultGroup('category.name')

        ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Наименование')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ed')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                     ->label('Цена')
                     ->numeric(decimalPlaces: 2,decimalSeparator: '.',thousandsSeparator: ','),
                Tables\Columns\ImageColumn::make('image')
                      ->label('фото'),
                Tables\Columns\TextColumn::make('info')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
               SelectFilter::make('category_id')
                   ->label('категория')
                  ->options(Category::pluck('name','id')),
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([

                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('manage')
                    ->label('История продаж')
                    ->icon('heroicon-m-bars-3-bottom-right')
                    ->url(fn(Product $record)=> ProductResource::getUrl('manage',[$record]))
                 ])
                ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                  //  Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'view' => Pages\ViewProduct::route('/{record}/view'),
            'manage' => Pages\ManProduct::route('/{record}/manage'),
        ];
    }
}
