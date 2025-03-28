<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Translation;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\TranslationExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TranslationResource\Pages;
use App\Filament\Resources\TranslationResource\RelationManagers;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Übersetzungen';

    protected static ?string $pluralModelLabel = 'Übersetzungen';
    protected static ?string $modelLabel = 'Übersetzungs-Eintrag';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->disabled(),
                Forms\Components\TextInput::make('de')
                    ->label('Deutsch')
                    ->maxLength(200),
                    Forms\Components\TextInput::make('fr')
                    ->label('Französisch')
                    ->maxLength(200),
                    Forms\Components\TextInput::make('it')
                    ->label('Italienisch')
                    ->maxLength(200),
                    Forms\Components\TextInput::make('en')
                    ->label('Englisch')
                    ->maxLength(200),    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('de')
                    ->label('Deutsch')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('fr')
                    ->label('Französisch')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('it')
                    ->label('Italienisch')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('en')
                    ->label('Englisch')
                    ->searchable(),                   
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
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
                ExportAction::make()->exporter(TranslationExporter::class)
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
            'index' => Pages\ListTranslations::route('/'),
            'create' => Pages\CreateTranslation::route('/create'),
            'edit' => Pages\EditTranslation::route('/{record}/edit'),
        ];
    }
}
