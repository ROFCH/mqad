<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Note;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NoteResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NoteResource\RelationManagers;

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Verwaltung';
    protected static ?string $navigationLabel = 'Mitarbeiterinformationen';

    protected static ?string $pluralModelLabel = 'Mitarbeiterinformationen';
    protected static ?string $modelLabel = 'Mitarbeiterinformationen';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([

                Forms\Components\Textarea::make('textde')
                    ->label('Meldung')
                    ->rows(4)
                    ,
                
                // Forms\Components\Select::make('users')
                //     ->label('Wer hat es schon gelesen?')
                //     ->multiple()
                //     ->preload()
                //     ->relationship('users','name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Datum')
                    ->date(),
                Tables\Columns\TextColumn::make('textde')
                    ->label('Meldung')
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
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'edit' => Pages\EditNote::route('/{record}/edit'),
        ];
    }
}
