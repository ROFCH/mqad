<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipFormatResource\Pages;
use App\Filament\Resources\ShipFormatResource\RelationManagers;
use App\Models\ShipFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShipFormatResource extends Resource
{
    protected static ?string $model = ShipFormat::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Versandformat-Typen';

    protected static ?string $pluralModelLabel = 'Versandformat-Typen';
    protected static ?string $modelLabel = 'Versandformat-Typ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('textde')
                    ->maxLength(30),
                Forms\Components\TextInput::make('maxweight')
                    ->numeric(),
                Forms\Components\TextInput::make('maxnumber')
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('weight')
                    ->numeric(),
                Forms\Components\TextInput::make('lot')
                    ->numeric(),
                Forms\Components\TextInput::make('remark')
                    ->maxLength(100),
                Forms\Components\TextInput::make('nextformat')
                    ->numeric(),
                Forms\Components\TextInput::make('translation_id')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('textde')
                    ->searchable(),
                Tables\Columns\TextColumn::make('maxweight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maxnumber')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lot')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remark')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nextformat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('translation_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListShipFormats::route('/'),
            'create' => Pages\CreateShipFormat::route('/create'),
            'edit' => Pages\EditShipFormat::route('/{record}/edit'),
        ];
    }
}
