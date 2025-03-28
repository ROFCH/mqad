<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VersionsRelationManager extends RelationManager
{
    protected static string $relationship = 'versions';
    protected static ?string $title = 'Auswertungs-Version';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('address_id')
                //     ->required()
                //     ->maxLength(255),

                Forms\Components\TextInput::make('version'),

                Forms\Components\TextInput::make('remark')
                ->label('Bemerkung'),
                Forms\Components\Select::make('user_id')
                    ->label('Benutzer')
                    ->required()
                    ->preload()
                    ->relationship(
                        name:'user',
                        titleAttribute: 'name'),



                Forms\Components\TextInput::make('user_id')
                ->label('Benutzer')
                ->numeric(),
                Forms\Components\TextInput::make('year')
                ->label('Jahr'),
                Forms\Components\TextInput::make('quarter')
                ->label('Quartal'),
                Forms\Components\TextInput::make('survey_id')
                ->label('Ringversuch'),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('address_id')
            ->defaultSort(function (Builder $query): Builder {
                return $query
                ->orderBy('year','desc')
                ->orderBy('quarter','desc');
                })
            ->columns([
                Tables\Columns\TextColumn::make('version'),
                Tables\Columns\TextColumn::make('remark')
                    ->label('Bemerkung'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Benutzer'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr'),
                Tables\Columns\TextColumn::make('quarter')
                    ->label('Quartal'),
                Tables\Columns\TextColumn::make('survey_id')
                    ->label('Ringversuch'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Neuer Eintrag')
                ->icon('heroicon-s-plus')
                ->modalHeading('Neue Auswertungs-Version'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('Auswertungs-Version bearbeiten'),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
