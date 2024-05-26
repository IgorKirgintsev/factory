<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Category;
use App\Models\Product;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Actions\Action;
use App\Models\BodyOrder;

class BodyOrderRelationManager extends RelationManager
{
    protected static string $relationship = 'BodyOrder';
    protected static ?string $modelLabel = 'Товары и услуги';
    protected static ?string $pluralModelLabel = 'Товары и услуги';
    protected static ?string $title = 'Товары и услуги ';

    public $bbsum;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->description('Товары и услуги')
                ->columns(2)
                ->schema([
                 Forms\Components\Select::make('category_id')
                  ->label('Категория')
                   ->relationship(name:'category',titleAttribute:'name')
                   ->preload()
                   ->live()
                   ->required(),

                 Forms\Components\Select::make('product_id')
                  ->label('Товары')
                  ->preload()
                  ->options(function (Get $get){
                        return Product::query()->where('category_id',$get('category_id'))->pluck('name','id');
                    })
                   ->required()
                   ->reactive()
                  // ->live(onBlur:true)
                  // установка цены
                   ->afterStateUpdated(fn($state,Set $set)=>$set('price',Product::find($state)?->price ?? 0)),
                  ]),

                   Forms\Components\Section::make()
                   ->description('данные')
                   ->columns(2)
                   ->schema([
                     Forms\Components\TextInput::make('price')
                     ->label('Цена')
                     ->default(1)
                     // ->live(onBlur:true)
                     ->numeric(2,'.',','),

                     Forms\Components\TextInput::make('kol')
                     ->label('Количество')
                     ->numeric(1, '.',',')
                     ->default(1)
                     ->required(),


                  ])
            ]);

        }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('border')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                 ->label('Материалы и товары'),
                Tables\Columns\TextColumn::make('kol')
                 ->label('Кол-во')
                 ->numeric(decimalPlaces: 0,decimalSeparator: '.',thousandsSeparator: ','),
                Tables\Columns\TextColumn::make('price')
                  ->label('Цена')
                  ->numeric(decimalPlaces: 2,decimalSeparator: '.',thousandsSeparator: ','),
                Tables\Columns\TextColumn::make('bsum')
                   ->label('Сумма')
                   ->numeric(decimalPlaces: 2,decimalSeparator: '.',thousandsSeparator: ',')
                  ->summarize(Sum::make()
                  ->label('Итого')
                  ->numeric(decimalPlaces: 2,decimalSeparator: '.',thousandsSeparator: ',')),
                ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Новая строка')    // изменеие данных перед записью !
                  ->mutateFormDataUsing(function (array $data): array {
                    $data['bsum'] = $data['kol'] * $data['price'];

                    return $data;
                }),

                ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['bsum'] = $data['kol'] * $data['price'];

                    return $data;
                }),

                Tables\Actions\DeleteAction::make(),


            ])
            ->bulkActions([
                 Tables\Actions\BulkActionGroup::make([
             //       Tables\Actions\DeleteBulkAction::make(),
                 ]),
            ]);
    }
}
