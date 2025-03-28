<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatustargetResource\Pages;
use App\Filament\Resources\StatustargetResource\RelationManagers;
use App\Models\Statustarget;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatustargetResource extends Resource
{
    protected static ?string $model = Statustarget::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Zielwerttypen';

    protected static ?string $pluralModelLabel = 'Zielwerttypen';
    protected static ?string $modelLabel = 'Zielwerttyp';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id'),
                Forms\Components\TextInput::make('textde')
                    ->required()
                    ->maxLength(50)
                    ->default(0),
                Forms\Components\TextInput::make('translation_id')
                    ->required()
                    ->numeric()
                    ->default(0),
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
            'index' => Pages\ListStatustargets::route('/'),
            'create' => Pages\CreateStatustarget::route('/create'),
            'edit' => Pages\EditStatustarget::route('/{record}/edit'),
        ];
    }
}
