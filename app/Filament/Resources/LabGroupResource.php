<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabGroupResource\Pages;
use App\Filament\Resources\LabGroupResource\RelationManagers;
use App\Models\LabGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LabGroupResource extends Resource
{
    protected static ?string $model = LabGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Labor-Gruppen';

    protected static ?string $pluralModelLabel = 'Labor-Gruppen';
    protected static ?string $modelLabel = 'Labor-Gruppe';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('textde')
                ->label('Bezeichnung'),
                Forms\Components\TextInput::make('remarks')
                ->label('Bemerkungen'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('textde')
                    ->label('Bezeichnung')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->label('Bemerkungen')
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
            'index' => Pages\ListLabGroups::route('/'),
            'create' => Pages\CreateLabGroup::route('/create'),
            'edit' => Pages\EditLabGroup::route('/{record}/edit'),
        ];
    }
}
