<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Unit;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UnitResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UnitResource\RelationManagers;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Einheiten pro Substanz';

    protected static ?string $pluralModelLabel = 'Einheiten pro Substanz';
    protected static ?string $modelLabel = 'Einheit pro Substanz';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('substance_id')
                    ->label('Substanz')
                    ->relationship('substance', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} ({$record->textde})")
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('sort')
                    ->label('Reihenfolge der Einheit (1=Standard/SI)')
                    ->helperText('Vorher in der Tabelle schauen, welche Zahlen es bereits gibt')
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('unit_symbol_id')
                    ->label('Einheitsabkürzung')
                    ->relationship('unitSymbol', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} ({$record->textde})")
                    ->preload(),
                Forms\Components\TextInput::make('decimals')
                    ->label('Kommastellen')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('conversion')
                    ->label('Umwandungsfaktor')
                    ->numeric()
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('substance.textde')
                    ->searchable()
                    ->label('Substanz')
                    ->toggleable(),
                    Tables\Columns\TextColumn::make('substance_id')
                    ->label('SubstanzID')
                    ->searchable(isIndividual: true)
                    ->toggleable(),    
                Tables\Columns\TextColumn::make('sort')
                    ->label('Reihenfolge')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('unitSymbol.textde')
                    ->label('Einheit')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('decimals')
                    ->label('Kommastellen')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('conversion')
                    ->numeric()
                    ->label("Umwandlung")
                    ->toggleable(),
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
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }
}
