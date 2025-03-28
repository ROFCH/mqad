<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefdataResource\Pages;
use App\Filament\Resources\RefdataResource\RelationManagers;
use App\Models\Refdata;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RefdataResource extends Resource
{
    protected static ?string $model = Refdata::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Refdata';

    protected static ?string $pluralModelLabel = 'Refdata (QUALAB GLN)';
    protected static ?string $modelLabel = 'Rerdata (QUALAB GLN)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('gln')
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->numeric(),
                Forms\Components\TextInput::make('language')
                    ->maxLength(2),
                Forms\Components\TextInput::make('name1')
                    ->maxLength(100),
                Forms\Components\TextInput::make('name2')
                    ->maxLength(100),
                Forms\Components\TextInput::make('type')
                    ->maxLength(10),
                Forms\Components\TextInput::make('street')
                    ->maxLength(100),
                Forms\Components\TextInput::make('postal_code')
                    ->numeric(),
                Forms\Components\TextInput::make('place')
                    ->maxLength(100),
                Forms\Components\TextInput::make('canton')
                    ->maxLength(2),
                Forms\Components\TextInput::make('country')
                    ->maxLength(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gln')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('language')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('place')
                    ->searchable(),
                Tables\Columns\TextColumn::make('canton')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
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
            'index' => Pages\ListRefdatas::route('/'),
            'create' => Pages\CreateRefdata::route('/create'),
            'edit' => Pages\EditRefdata::route('/{record}/edit'),
        ];
    }
}
