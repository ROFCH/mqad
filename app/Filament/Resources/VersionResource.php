<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VersionResource\Pages;
use App\Filament\Resources\VersionResource\RelationManagers;
use App\Models\Version;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VersionResource extends Resource
{
    protected static ?string $model = Version::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'Auswertung-Versionen';


    protected static ?string $pluralModelLabel = 'Auswertungs-Versionen';
    protected static ?string $modelLabel = 'Auswertungs-Version';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('address_id')
                    ->relationship('address', 'name'),
                Forms\Components\TextInput::make('year')
                    ->numeric(),
                Forms\Components\TextInput::make('quarter')
                    ->numeric(),
                Forms\Components\TextInput::make('survey_id')
                    ->numeric(),
                Forms\Components\TextInput::make('version')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('created'),
                Forms\Components\TextInput::make('remark')
                    ->maxLength(200),
                Forms\Components\TextInput::make('user_id')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quarter')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('survey_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remark')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
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
            'index' => Pages\ListVersions::route('/'),
            'create' => Pages\CreateVersion::route('/create'),
            'edit' => Pages\EditVersion::route('/{record}/edit'),
        ];
    }
}
