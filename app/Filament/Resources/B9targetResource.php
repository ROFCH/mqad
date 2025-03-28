<?php

namespace App\Filament\Resources;

use App\Filament\Resources\B9targetResource\Pages;
use App\Filament\Resources\B9targetResource\RelationManagers;
use App\Models\B9target;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class B9targetResource extends Resource
{
    protected static ?string $model = B9target::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'B9 Zielwerte';

    protected static ?string $pluralModelLabel = 'B9 Zielwerte';
    protected static ?string $modelLabel = 'B9 Zielwert';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('year')
                    ->numeric(),
                Forms\Components\TextInput::make('quarter')
                    ->numeric(),
                Forms\Components\Select::make('method_id')
                    ->relationship('method', 'id'),
                Forms\Components\TextInput::make('value')
                    ->numeric(),
                Forms\Components\TextInput::make('log')
                    ->numeric(),
                Forms\Components\TextInput::make('knr')
                    ->numeric(),
                Forms\Components\TextInput::make('points')
                    ->numeric(),
                Forms\Components\Select::make('survey_id')
                    ->relationship('survey', 'id'),
                Forms\Components\TextInput::make('textde')
                    ->maxLength(80),
                Forms\Components\TextInput::make('sort')
                    ->numeric(),
                Forms\Components\TextInput::make('type')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('survey_id'),
                Tables\Columns\TextColumn::make('survey.year'),
                Tables\Columns\TextColumn::make('survey.quarter'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('quarter')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('method.id')

                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('log')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('knr')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('points')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('textde')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
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
            'index' => Pages\ListB9targets::route('/'),
            'create' => Pages\CreateB9target::route('/create'),
            'edit' => Pages\EditB9target::route('/{record}/edit'),
        ];
    }
}
