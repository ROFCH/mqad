<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Method;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Exports\MethodExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MethodResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MethodResource\RelationManagers;

class MethodResource extends Resource
{
    protected static ?string $model = Method::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Methoden';

    protected static ?string $pluralModelLabel = 'Methoden';
    protected static ?string $modelLabel = 'Methode';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->disabled(),
                Forms\Components\TextInput::make('number')
                    ->numeric(),


                Forms\Components\Select::make('substance_id')
                    ->relationship('substance', 'textde')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(1000)
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} ({$record->textde})") ,


                    
                Forms\Components\Select::make('instrument_id')
                    ->relationship('instrument', 'id')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(1000)
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} ({$record->textde})") ,
                Forms\Components\TextInput::make('sort')
                    ->numeric(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('number')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('substance.textde')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('instrument.textde')
                    ->numeric()
                    ->sortable(),
                //Tables\Columns\TextColumn::make('substancede')
                //    ->searchable(),
                //Tables\Columns\TextColumn::make('instrumentde')
                //    ->searchable(),
                Tables\Columns\TextColumn::make('sort'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->headerActions([
                ExportAction::make()->exporter(MethodExporter::class)
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
            RelationManagers\ProtocolsRelationManager::class,
            RelationManagers\ResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMethods::route('/'),
            'create' => Pages\CreateMethod::route('/create'),
            'edit' => Pages\EditMethod::route('/{record}/edit'),
        ];
    }
}
