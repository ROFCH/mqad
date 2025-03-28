<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SterilizersRelationManager extends RelationManager
{
    protected static string $relationship = 'Sterilizers';
    protected static ?string $title = 'Sterilisatorkontrolle';

    public function form(Form $form): Form
    {
        return $form
            ->columns(5)
            ->schema([
                Forms\Components\TextInput::make('ship_lot')
                    ->label('Versand Lot')
                    ->columnStart(1),
                Forms\Components\DatePicker::make('shipping')
                    ->date("d.m.Y")
                    ->label('Versanddatum'),
                Forms\Components\DatePicker::make('testing')
                ->columnStart(1)
                ->date("d.m.Y")
                ->label('Versanddatum'),
                Forms\Components\TextInput::make('inc_lot')
                ->columnStart(1)
                ->label('Inkubations Lot'),
                Forms\Components\DatePicker::make('incubation')
                ->date("d.m.Y")
                ->label('Inkubationsdatum'),
                Forms\Components\TextInput::make('strip1')
                    ->columnStart(1)
                    ->numeric(),
                Forms\Components\TextInput::make('strip2')
                    ->numeric(),
                Forms\Components\TextInput::make('strip3')
                    ->numeric(),
                Forms\Components\TextInput::make('strip4')
                    ->numeric(),
                Forms\Components\TextInput::make('striptk')
                    ->numeric(),

                Forms\Components\TextInput::make('sterilizer')
                    ->columnStart(1)
                    ->columnSpan(2),

                Forms\Components\TextInput::make('conditions')
                    ->columnSpan(2),
                Forms\Components\TextInput::make('year')
                    ->default(date('Y'))
                    ->columnStart(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('address_id')
            
            ->columns([


            Tables\Columns\TextColumn::make('ship_lot')
                ->label('Versand Lot')
                ->alignCenter(),
            Tables\Columns\TextColumn::make('shipping')
                ->label('Versand Datum')
                ->date("d.m.Y")
                ->alignCenter(),
            Tables\Columns\TextColumn::make('testing')
                ->label('Test Datum')
                ->date("d.m.Y")
                ->alignCenter(),
            Tables\Columns\TextColumn::make('inc_lot')
                ->label('Ink Lot')
                ->alignCenter(),    
            Tables\Columns\TextColumn::make('incubation')
                ->label('Inkubation Datum')
                ->date("d.m.Y")
                ->alignCenter(),
            Tables\Columns\TextColumn::make('strip1')
                ->label('St 1')
                ->alignCenter(),
            Tables\Columns\TextColumn::make('strip2')
                ->label('St 2')
                ->alignCenter(),
            Tables\Columns\TextColumn::make('strip3')
                ->label('St 3')
                ->alignCenter(),
            Tables\Columns\TextColumn::make('strip4')
                ->label('St 4')
                ->alignCenter(),
            Tables\Columns\TextColumn::make('striptk')
                ->label('KT')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('sterilizer')
                ->label('Sterilisator')
                ->searchable(),
            Tables\Columns\TextColumn::make('conditions')
                ->label('Bedingungen')
                ->searchable(),
            Tables\Columns\TextColumn::make('year')
                ->label('Jahr')
                ->alignCenter(),
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
            ->headerActions([
                Tables\Actions\CreateAction::make()
                     ->label('Neuer Eintrag')
                      ->icon('heroicon-s-plus')
                     ->modalHeading('Neue Sterilisatorkontrolle')
                    ->slideOver(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalHeading('Sterilisatorkontrolle bearbeiten'),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
