<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JournalTypeResource\Pages;
use App\Filament\Resources\JournalTypeResource\RelationManagers;
use App\Models\JournalType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JournalTypeResource extends Resource
{
    protected static ?string $model = JournalType::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Ereignis-Typen';

    protected static ?string $pluralModelLabel = 'Ereignis-Typen';
    protected static ?string $modelLabel = 'Ereignis-Typ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('textde')
                    ->maxLength(50),
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
            'index' => Pages\ListJournalTypes::route('/'),
            'create' => Pages\CreateJournalType::route('/create'),
            'edit' => Pages\EditJournalType::route('/{record}/edit'),
        ];
    }
}
