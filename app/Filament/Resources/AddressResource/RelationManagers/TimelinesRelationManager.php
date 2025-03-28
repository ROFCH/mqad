<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class TimelinesRelationManager extends RelationManager
{
    protected static string $relationship = 'timelines';
    protected static ?string $title = 'Verlauf';

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titel')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('text')
                    ->columnSpanFull()
                        ->label('Beschreibung')
                        ->rows(5),    
                Forms\Components\TextInput::make('remark')
                    ->columnSpanFull()
                        ->required()
                        ->maxLength(255),      
                Forms\Components\TextInput::make('year')
                    ->label('Jahr')
                    ->columnStart(1)
                    ->columnSpan(1)
                    ->default(date("Y")),
                Forms\Components\TextInput::make('quarter')
                    ->label('Quartal')
                    ->columnSpan(1),
                Forms\Components\TextInput::make('user')
                    ->label('MQ Mitarbeiter')
                    ->columnSpan(1),
                        

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
            ->recordTitleAttribute('title')
            ->columns([

                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr'),
                Tables\Columns\TextColumn::make('quarter')
                    ->label('Quartal'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titel'),
            ])
            ->filters([
                Filter::make('Standard Jahr')->query(
                    function (Builder $query): Builder {
                        //return $query->where('year',date("Y"));
                        return $query->where('year','>=',date("Y")-1);
                    }
                ) ->label('Aktuelles und letztes Jahr')->default(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Neuer Eintrag')
                ->icon('heroicon-s-plus')
                ->modalHeading('Neuer Verlaufseintrag'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('Verlaufs-Eintrag bearbeiten'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
