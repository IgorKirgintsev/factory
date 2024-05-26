<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MproductResource\Pages;
use App\Filament\Resources\MproductResource\RelationManagers;
use App\Models\Mproduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Support\Enums\FontWeight;


class MproductResource extends Resource
{



    protected static ?string $model = Mproduct::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Изделия';
    protected static ?string $modelLabel = 'Изделия';
    protected static ?string $pluralModelLabel = 'Изделия';
    protected static ?string $navigationGroup = 'Изделия';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\TextInput::make('product_id')
//                    ->required()
//                    ->numeric(),
//                Forms\Components\TextInput::make('category_id')
//                    ->required()
//                    ->numeric(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('info')
//                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->image(),
//                    ->required(),
                Forms\Components\TextInput::make('price')
//
                    ->default(0)
                    ->numeric(),
//                    ->prefix('$'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->selectable()    //выбирать записи по галочке
        ->columns([
                Stack::make([

                Tables\Columns\ImageColumn::make('image')
                    ->height('100%')
                    ->width('100%'),
                    Tables\Columns\TextColumn::make('name')
                    ->weight(FontWeight::Bold),
                Tables\Columns\TextColumn::make('info'),

                      ])->space(3),

                 ])
                  ->contentGrid([
                    'md' => 2,
                    'xl' => 3,
               ])



            ->filters([
                //
            ])
            ->actions([
               Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('manage')
                 ->label('История заказов')
                 ->icon('heroicon-m-bars-3-bottom-right')
                 ->url(fn(Mproduct $record)=> MproductResource::getUrl('manage',[$record]))


              ])
               ->label('Действия')         // настройка меню действий
               ->icon('heroicon-m-ellipsis-vertical')
               ->size('ActionSize::Small')
               ->color('gray')
               ->dropdownPlacement('top-start')
               ->button()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
        //            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMproducts::route('/'),
            'create' => Pages\CreateMproduct::route('/create'),
            'edit' => Pages\EditMproduct::route('/{record}/edit'),
            'view' => Pages\ViewCustMproduct::route('/{record}/view'),
            'manage' => Pages\ManMproduct::route('/{record}/manage'),
        ];
    }




}
