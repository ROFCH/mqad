<?php

namespace App\Filament\Resources;

use App\Filament\Resources\B9protocolResource\Pages;
use App\Filament\Resources\B9protocolResource\RelationManagers;
use App\Models\B9protocol;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class B9protocolResource extends Resource
{
    protected static ?string $model = B9protocol::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'B9 Protokolle';

    protected static ?string $pluralModelLabel = 'B9 Protokolle';
    protected static ?string $modelLabel = 'B9 Protokolle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sample')
                    ->numeric(),
                Forms\Components\TextInput::make('suscept')
                    ->numeric(),
                Forms\Components\TextInput::make('material')
                    ->maxLength(85),
                Forms\Components\TextInput::make('diagnosis')
                    ->maxLength(85),
                Forms\Components\TextInput::make('language')
                    ->numeric(),
                Forms\Components\TextInput::make('question')
                    ->maxLength(85),
                Forms\Components\TextInput::make('blab')
                    ->numeric(),
                Forms\Components\Select::make('survey_id')
                    ->relationship('survey', 'id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

        ->defaultSort(function (Builder $query): Builder {
            return $query
            ->orderBy('survey_id','desc')
            ->orderBy('sample','asc')
            ->orderBy('language_id','asc');
        })

            ->columns([
                Tables\Columns\TextColumn::make('survey.quarter'),
                Tables\Columns\TextColumn::make('survey.year'),
                Tables\Columns\TextColumn::make('sample')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('suscept')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('material')
                    ->searchable(),
                Tables\Columns\TextColumn::make('diagnosis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('language_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('question')
                    ->searchable(),
                Tables\Columns\TextColumn::make('blab')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('survey.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListB9protocols::route('/'),
            'create' => Pages\CreateB9protocol::route('/create'),
            'edit' => Pages\EditB9protocol::route('/{record}/edit'),
        ];
    }
}
