<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JournalsRelationManager extends RelationManager
{
    protected static string $relationship = 'Journals';
    protected static ?string $title = 'Ereignisse';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('journaltype_id')
                    ->label('Ereignistyp')
                    ->relationship('journaltype','textde'),
                Forms\Components\TextInput::make('sample')
                    ->label('Titel / Kurzlieferschein'),    
                    Forms\Components\TextInput::make('remark')
                    ->label('Bemerkungen'),     
                    Forms\Components\TextInput::make('year')
                    ->label('Jahr'),
                    Forms\Components\TextInput::make('quarter')
                    ->label('Quartal'),
                    Forms\Components\TextInput::make('survey_id')
                    ->label('Ringversuch'),
                    Forms\Components\TextInput::make('user')
                    ->label('Benutzer'),                    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
        ->defaultSort(function (Builder $query): Builder {
            return $query
            ->orderBy('year','desc')
            ->orderBy('quarter','desc');
            })

            ->recordTitleAttribute('sample')
            ->columns([
                Tables\Columns\TextColumn::make('journaltype.textde')
                    ->label('Ereignistyp'),
                Tables\Columns\TextColumn::make('sample')
                    ->label('Titel / Kurzlieferschein'),
                Tables\Columns\TextColumn::make('remark')
                    ->label('Bemerkung'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr'),
                Tables\Columns\TextColumn::make('quarter')
                    ->label('Quartal'),
                Tables\Columns\TextColumn::make('survey_id')
                    ->label('Ringversuch'),
                Tables\Columns\TextColumn::make('user')
                    ->label('Benutzer'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Neuer Eintrag')
                    ->icon('heroicon-s-plus')
                    ->modalHeading('Neues Ereignis'),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
