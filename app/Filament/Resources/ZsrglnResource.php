<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ZsrglnResource\Pages;
use App\Filament\Resources\ZsrglnResource\RelationManagers;
use App\Models\Zsrgln;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ZsrglnResource extends Resource
{
    protected static ?string $model = Zsrgln::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'ZSR und GLN Nummern';

    protected static ?string $pluralModelLabel = 'ZSR und GLN Nummern';
    protected static ?string $modelLabel = 'ZSR und GLN Nummer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('address_id')
                    ->relationship('address', 'name'),
                Forms\Components\TextInput::make('type')
                    ->maxLength(24),
                Forms\Components\TextInput::make('name')
                    ->maxLength(50),
                Forms\Components\TextInput::make('surname')
                    ->maxLength(50),
                Forms\Components\TextInput::make('additional')
                    ->maxLength(30),
                Forms\Components\TextInput::make('postalnumber')
                    ->maxLength(6),
                Forms\Components\TextInput::make('place')
                    ->maxLength(24),
                Forms\Components\TextInput::make('zsr')
                    ->maxLength(16),
                Forms\Components\TextInput::make('gln')
                    ->maxLength(14),
                Forms\Components\TextInput::make('from_year')
                    ->numeric(),
                Forms\Components\TextInput::make('till_year')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('surname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('additional')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postalnumber')
                    ->searchable(),
                Tables\Columns\TextColumn::make('place')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zsr')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gln')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('from_year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('till_year')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListZsrglns::route('/'),
            'create' => Pages\CreateZsrgln::route('/create'),
            'edit' => Pages\EditZsrgln::route('/{record}/edit'),
        ];
    }
}
