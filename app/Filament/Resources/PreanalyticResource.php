<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PreanalyticResource\Pages;
use App\Filament\Resources\PreanalyticResource\RelationManagers;
use App\Models\Preanalytic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PreanalyticResource extends Resource
{
    protected static ?string $model = Preanalytic::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Präanalytik Fragen';

    protected static ?string $pluralModelLabel = 'Präanalytik Fragen';
    protected static ?string $modelLabel = 'Präanalytik Fragen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('evaluation')
                    ->numeric(),
                Forms\Components\TextInput::make('textde')
                    ->maxLength(100),
                Forms\Components\TextInput::make('menude')
                    ->maxLength(100),
                Forms\Components\TextInput::make('method_id')
                    ->numeric(),
                Forms\Components\TextInput::make('menu_num')
                    ->numeric(),
                Forms\Components\Select::make('translation_id')
                    ->relationship('translation', 'id'),
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
                ->orderBy('method_id','asc');
            })


            ->columns([
                Tables\Columns\TextColumn::make('survey.quarter'),
                Tables\Columns\TextColumn::make('survey.year'),
                Tables\Columns\TextColumn::make('method.substancede'),
                Tables\Columns\TextColumn::make('method.instrumentde'),


                Tables\Columns\TextColumn::make('evaluation')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('textde')
                    ->searchable(),
                Tables\Columns\TextColumn::make('menude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('method_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('menu_num')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('translation.id')
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
            'index' => Pages\ListPreanalytics::route('/'),
            'create' => Pages\CreatePreanalytic::route('/create'),
            'edit' => Pages\EditPreanalytic::route('/{record}/edit'),
        ];
    }
}
