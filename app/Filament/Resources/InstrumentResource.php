<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Instrument;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\InstrumentExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InstrumentResource\Pages;
use App\Filament\Resources\InstrumentResource\RelationManagers;

class InstrumentResource extends Resource
{
    protected static ?string $model = Instrument::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Geräte';

    protected static ?string $pluralModelLabel = 'Geräte';
    protected static ?string $modelLabel = 'Gerät';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('id')
                ->disabled(),
                Forms\Components\TextInput::make('textde')
                    ->label('Gerätebezeichnung (für die Erstellung einer Methode mit eigenem Sollwert)')
                    ->maxLength(30),
                Forms\Components\TextInput::make('translation_id')
                    ->label('Übersetzungsnummer'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('translation.de')
                    ->label('Deutsch')
                    ->searchable(),
                Tables\Columns\TextColumn::make('translation.fr')
                    ->label('Französisch')
                    ->searchable(),
                Tables\Columns\TextColumn::make('translation.it')
                    ->label('Italienisch')
                    ->searchable(),
                Tables\Columns\TextColumn::make('translation.en')
                    ->label('Englisch')
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
                ExportAction::make()->exporter(InstrumentExporter::class)
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
            'index' => Pages\ListInstruments::route('/'),
            'create' => Pages\CreateInstrument::route('/create'),
            'edit' => Pages\EditInstrument::route('/{record}/edit'),
        ];
    }
}
