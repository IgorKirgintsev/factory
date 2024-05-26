<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Actions;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\Facades\Mail;
use Filament\Infolists\Components\TextEntry;
use App\Mail\ClientEmail;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Покупатели';
    protected static ?string $modelLabel = 'Покупатель';
    protected static ?string $pluralModelLabel = 'Покупатели';
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?int $navigationSort = 4;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('inn')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('adres')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefon')
                    ->tel()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->size(TextColumn\TextColumnSize::Large),
                    Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->iconColor('primary'),
                    Tables\Columns\TextColumn::make('inn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('adres')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefon')
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
                //
            ])
            ->actions([

                Tables\Actions\ActionGroup::make([

                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),

                //отправка писем
                Tables\Actions\Action::make('Отправить_письмо')
                     // текущие данные модели
                   ->fillForm(fn (Client $record): array => [
                    'email' => $record->email
                    ])
                    //
                  ->icon('heroicon-m-envelope')
                  ->form([
                    Forms\Components\TextInput::make('email')
                      ->label('Получатель')
                      ->readOnly(),
                    Forms\Components\TextInput::make('subject')->required()
                      ->label('Тема письма'),
                    Forms\Components\MarkdownEditor::make('body')->required()
                      ->label('Текст письма'),
                    ])
                 ->action(function (array $data) {
                    Mail::to($data['email'])
                       ->send(new ClientEmail(
                           $data['subject'],
                           $data['body'],
                       ));
                   }),
                   //



               ])

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
            'view' => Pages\ViewClient::route('/{record}/view'),
        ];
    }
}
