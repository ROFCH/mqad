<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\UnitSymbol;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\UnitSymbolExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UnitSymbolResource\Pages;
use App\Filament\Resources\UnitSymbolResource\RelationManagers;

class UnitSymbolResource extends Resource
{
    protected static ?string $model = UnitSymbol::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Einheiten Symbole';


    protected static ?string $pluralModelLabel = 'Einheiten Symbole';
    protected static ?string $modelLabel = 'Einheiten Symbol';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->disabled(),
                Forms\Components\TextInput::make('textde')
                    ->label('Abkürzung der Einheit')
                    ->maxLength(20),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('textde')
                    ->label('Abkürzung der Einheit')
                    ->searchable(),
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

            ->headerActions([
                ExportAction::make()->exporter(UnitSymbolExporter::class)
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
            'index' => Pages\ListUnitSymbols::route('/'),
            'create' => Pages\CreateUnitSymbol::route('/create'),
            'edit' => Pages\EditUnitSymbol::route('/{record}/edit'),
        ];
    }
}
