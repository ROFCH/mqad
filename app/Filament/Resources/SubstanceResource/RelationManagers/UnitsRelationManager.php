<?php

namespace App\Filament\Resources\SubstanceResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class UnitsRelationManager extends RelationManager
{
    protected static string $relationship = 'Units';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('substance_id')
                // ->label('Substanz')
                // ->relationship('substance', 'id')
                // ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} ({$record->textde})")
                // ->preload()
                // ->searchable(),
            Forms\Components\TextInput::make('sort')
                ->label('Reihenfolge der Einheit (1=Standard/SI)')
                ->helperText('Vorher in der Tabelle schauen, welche Zahlen es bereits gibt')
                ->numeric()
                ->default(0),
            Forms\Components\Select::make('unit_symbol_id')
                ->label('Einheitsabkürzung')
                ->relationship('unitSymbol', 'id')
                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} ({$record->textde})")
                ->preload(),
            Forms\Components\TextInput::make('decimals')
                ->label('Kommastellen')
                ->numeric()
                ->default(0),
            Forms\Components\TextInput::make('conversion')
                ->label('Umwandungsfaktor')
                ->numeric()
                ->default(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('unit_id')
            ->columns([
                Tables\Columns\TextColumn::make('sort'),
                Tables\Columns\TextColumn::make('unitSymbol.textde')
                    ->label('Einheit'),
                Tables\Columns\TextColumn::make('decimals')
                    ->label('Kommastellen'),
                Tables\Columns\TextColumn::make('conversion')
                    ->label('Umwandlungsfaktor in Einheit Nr. 1'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
