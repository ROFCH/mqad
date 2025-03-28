<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SemiqntClassesResource\Pages;
use App\Filament\Resources\SemiqntClassesResource\RelationManagers;
use App\Models\SemiqntClasses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SemiqntClassesResource extends Resource
{
    protected static ?string $model = SemiqntClasses::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Semiquant Texte';

    protected static ?string $pluralModelLabel = 'Semiquant Texte';
    protected static ?string $modelLabel = 'Semiquant Texte';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('method_id')
                    ->relationship('method', 'id'),
                Forms\Components\TextInput::make('textde')
                    ->maxLength(50),
                Forms\Components\TextInput::make('unitde')
                    ->maxLength(20),
                Forms\Components\TextInput::make('f1')
                    ->maxLength(10),
                Forms\Components\TextInput::make('f2')
                    ->maxLength(10),
                Forms\Components\TextInput::make('f3')
                    ->maxLength(10),
                Forms\Components\TextInput::make('f4')
                    ->maxLength(10),
                Forms\Components\TextInput::make('f5')
                    ->maxLength(10),
                Forms\Components\TextInput::make('f6')
                    ->maxLength(10),
                Forms\Components\TextInput::make('f7')
                    ->maxLength(10),
                Forms\Components\TextInput::make('f8')
                    ->maxLength(10),
                Forms\Components\TextInput::make('f9')
                    ->maxLength(10),
                Forms\Components\TextInput::make('options')
                    ->maxLength(200),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('method.id')
                    ->numeric()
                    ->sortable(),
  
                Tables\Columns\TextColumn::make('textde')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unitde')
                    ->searchable(),
                Tables\Columns\TextColumn::make('f1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('f2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('f3')
                    ->searchable(),
                Tables\Columns\TextColumn::make('f4')
                    ->searchable(),
                Tables\Columns\TextColumn::make('f5')
                    ->searchable(),
                Tables\Columns\TextColumn::make('f6')
                    ->searchable(),
                Tables\Columns\TextColumn::make('f7')
                    ->searchable(),
                Tables\Columns\TextColumn::make('f8')
                    ->searchable(),
                Tables\Columns\TextColumn::make('f9')
                    ->searchable(),
                Tables\Columns\TextColumn::make('options')
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
            'index' => Pages\ListSemiqntClasses::route('/'),
            'create' => Pages\CreateSemiqntClasses::route('/create'),
            'edit' => Pages\EditSemiqntClasses::route('/{record}/edit'),
        ];
    }
}
