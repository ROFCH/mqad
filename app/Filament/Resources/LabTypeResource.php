<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabTypeResource\Pages;
use App\Filament\Resources\LabTypeResource\RelationManagers;
use App\Models\LabType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LabTypeResource extends Resource
{
    protected static ?string $model = LabType::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Labor-Typen';

    protected static ?string $pluralModelLabel = 'Labor-Typen';
    protected static ?string $modelLabel = 'Labor-Typ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id'),
                Forms\Components\TextInput::make('textde')
                    ->maxLength(50),
                Forms\Components\TextInput::make('translation_id')
                    ->numeric(),
                Forms\Components\TextInput::make('complexity')
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
                Tables\Columns\TextColumn::make('translation_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('complexity')
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
            'index' => Pages\ListLabTypes::route('/'),
            'create' => Pages\CreateLabType::route('/create'),
            'edit' => Pages\EditLabType::route('/{record}/edit'),
        ];
    }
}
