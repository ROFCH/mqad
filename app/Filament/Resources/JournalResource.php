<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JournalResource\Pages;
use App\Filament\Resources\JournalResource\RelationManagers;
use App\Models\Journal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JournalResource extends Resource
{
    protected static ?string $model = Journal::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'Ereignisse';

    protected static ?string $pluralModelLabel = 'Ereignisse';
    protected static ?string $modelLabel = 'Ereigniss';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('address_id')
                    ->relationship('address', 'name'),
                Forms\Components\Select::make('journalType_id')
                    ->relationship('journaltype', 'textde'),
                Forms\Components\TextInput::make('journalType_id'),    
                Forms\Components\TextInput::make('sample')
                    ->maxLength(50),
                Forms\Components\TextInput::make('remark')
                    ->maxLength(50),
                Forms\Components\TextInput::make('quarter')
                    ->numeric(),
                Forms\Components\TextInput::make('user')
                    ->maxLength(10),
                Forms\Components\TextInput::make('year')
                    ->numeric(),
                Forms\Components\TextInput::make('survey_id')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('address_id'),
                Tables\Columns\TextColumn::make('address.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('journaltype.textde')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sample')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remark')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('quarter')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('survey_id')
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
            'index' => Pages\ListJournals::route('/'),
            'create' => Pages\CreateJournal::route('/create'),
            'edit' => Pages\EditJournal::route('/{record}/edit'),
        ];
    }
}
