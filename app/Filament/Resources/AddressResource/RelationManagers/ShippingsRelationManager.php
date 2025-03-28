<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShippingsRelationManager extends RelationManager
{
    protected static string $relationship = 'shippings';
    protected static ?string $title = 'Versandinfo';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('shipping_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            //->defaultSort('year', 'desc')
            ->defaultSort(function (Builder $query): Builder {
                return $query
                ->orderBy('year','desc')
                ->orderBy('quarter','desc');
                })


            ->recordTitleAttribute('shipping_id')
            ->columns([
                Tables\Columns\TextColumn::make('schedule_type.textde')
                    ->label('Versandtyp'),
                Tables\Columns\TextColumn::make('note')
                    ->label('Kurz-Lieferschein'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr'),
                Tables\Columns\TextColumn::make('quarter')
                    ->label('Quartal'),
            ])
            ->filters([
                // Filter::make('Aktuelles Jahr')->query(
                //     function (Builder $query): Builder {
                //         //return $query->where('year',date("Y"));
                //         return $query->where('year',date("Y"));
                //     }
                // ) ->label('Aktuelles Jahr')->default(),

                // Filter::make('Letztes_Jahr')->query(
                //     function (Builder $query): Builder {
                //         return $query->where('year',date("Y")-1);
                //     }
                // ) ->label('Letztes Jahr'),

                // Filter::make('Vorletztes_Jahr')->query(
                //     function (Builder $query): Builder {
                //         return $query->where('year',date("Y")-2);
                //     }
                // ) ->label('Vorletztes Jahr')
            ])
            ->headerActions([

            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
    }
}
