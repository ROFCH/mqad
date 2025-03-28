<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BacteriaResource\Pages;
use App\Filament\Resources\BacteriaResource\RelationManagers;
use App\Models\Bacteria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BacteriaResource extends Resource
{
    protected static ?string $model = Bacteria::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Bakterien';

    protected static ?string $pluralModelLabel = 'Bakterien';
    protected static ?string $modelLabel = 'Bakterien';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([

                Forms\Components\TextInput::make('id'),

                Forms\Components\TextInput::make('textde')
                    ->label('Bakterienname')
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),

                Tables\Columns\TextColumn::make('textde')
                    ->label('Name')
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
            'index' => Pages\ListBacterias::route('/'),
            'create' => Pages\CreateBacteria::route('/create'),
            'edit' => Pages\EditBacteria::route('/{record}/edit'),
        ];
    }
}
