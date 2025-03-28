<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ZsrglnsRelationManager extends RelationManager
{
    protected static string $relationship = 'zsrglns';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                // Forms\Components\TextInput::make('address_id')
                //     ->required()
                //     ->maxLength(255),
                Forms\Components\TextInput::make('zsr')
                    ->label('ZSR'),   
                Forms\Components\TextInput::make('gln') 
                    ->label('GLN'),
                Forms\Components\TextInput::make('type') 
                    ->label('Typ gemäss SASIS'),
                    Forms\Components\TextInput::make('name') 
                    ->label('Name'),
                    Forms\Components\TextInput::make('surname') 
                    ->label('Vorname'),
                    Forms\Components\TextInput::make('additional') 
                    ->label('Zusatz'),
                    Forms\Components\TextInput::make('postalnumber') 
                    ->label('PLZ'),
                    Forms\Components\TextInput::make('place') 
                    ->label('Ort'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('address_id')
            ->columns([
                //Tables\Columns\TextColumn::make('address_id'),
                Tables\Columns\TextColumn::make('zsr')
                    ->label('ZSR'),
                Tables\Columns\TextColumn::make('gln')
                    ->label('GLN'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Typ gemäss SASIS'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name'),
                Tables\Columns\TextColumn::make('surname')
                    ->label('Vorname'),
                Tables\Columns\TextColumn::make('additional')
                    ->label('Zusatz'),
                Tables\Columns\TextColumn::make('postalnumber')
                    ->label('PLZ'),
                Tables\Columns\TextColumn::make('place')
                    ->label('Ort'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Neuer Eintrag')
                ->icon('heroicon-s-plus')
                ->modalHeading('Neue ZSR/GLN Nummer'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('ZSR/GLN Nummer bearbeiten'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
