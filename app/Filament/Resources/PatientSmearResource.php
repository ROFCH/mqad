<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientSmearResource\Pages;
use App\Filament\Resources\PatientSmearResource\RelationManagers;
use App\Models\PatientSmear;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientSmearResource extends Resource
{
    protected static ?string $model = PatientSmear::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Blutbild Angaben Patient';

    protected static ?string $pluralModelLabel = 'Blutbild Angaben Patient';
    protected static ?string $modelLabel = 'Blutbild Angaben Patient';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sample')
                    ->maxLength(10),
                Forms\Components\TextInput::make('age')
                    ->maxLength(10),
                Forms\Components\TextInput::make('sex')
                    ->maxLength(10),
                Forms\Components\TextInput::make('hb')
                    ->maxLength(10),
                Forms\Components\TextInput::make('hc')
                    ->maxLength(10),
                Forms\Components\TextInput::make('lc')
                    ->maxLength(10),
                Forms\Components\TextInput::make('tc')
                    ->maxLength(10),
                Forms\Components\TextInput::make('ec')
                    ->maxLength(10),
                Forms\Components\Select::make('survey_id')
                    ->relationship('survey', 'id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('survey_id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('survey.year')
                    ->label('Jahr'),
                Tables\Columns\TextColumn::make('survey.quarter')
                    ->label('Quartal'),   

                Tables\Columns\TextColumn::make('sample')
                    ->searchable(),
                Tables\Columns\TextColumn::make('age')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sex')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hb')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hc')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lc')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tc')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ec')
                    ->searchable(),
                Tables\Columns\TextColumn::make('survey_id')
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
            'index' => Pages\ListPatientSmears::route('/'),
            'create' => Pages\CreatePatientSmear::route('/create'),
            'edit' => Pages\EditPatientSmear::route('/{record}/edit'),
        ];
    }
}
