<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QualabResource\Pages;
use App\Filament\Resources\QualabResource\RelationManagers;
use App\Models\Qualab;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QualabResource extends Resource
{
    protected static ?string $model = Qualab::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Qualab';

    protected static ?string $pluralModelLabel = 'Qualab';
    protected static ?string $modelLabel = 'Qualab';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('al')
                    ->numeric(),
                Forms\Components\TextInput::make('subcode')
                    ->numeric(),
                Forms\Components\Select::make('translation_id')
                    ->relationship('translation', 'id'),
                Forms\Components\TextInput::make('tolerance')
                    ->numeric(),
                Forms\Components\TextInput::make('textde')
                    ->maxLength(20),
                Forms\Components\TextInput::make('sort')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([


                Tables\Columns\TextColumn::make('id'), 
                Tables\Columns\TextColumn::make('translation.de')
                    ->label('Bezeichnung auf Zertifikat')
                    ->searchable(), 
                Tables\Columns\TextInputColumn::make('al')
                    ->label('EAL')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subcode')
                    ->label('Subcode'),

                       
                Tables\Columns\TextColumn::make('tolerance')
                    ->label('Toleranz'),
                Tables\Columns\TextInputColumn::make('sort')
                    ->label('Qualab Reihenfolge'),
                    Tables\Columns\TextColumn::make('textde')
                    ->label('Bemerkung'),
              
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
            'index' => Pages\ListQualabs::route('/'),
            'create' => Pages\CreateQualab::route('/create'),
            'edit' => Pages\EditQualab::route('/{record}/edit'),
        ];
    }
}
