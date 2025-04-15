<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Auth\AuthManager;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;


class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';
    protected static ?string $title = 'Rechnungen';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                    Forms\Components\DatePicker::make('booking')
                        ->date('Y-m-d')
                        ->label('Buchungsdatum'),
                    Forms\Components\Select::make('product_id')
                        ->label('Buchung')
                        ->preload()
                        ->relationship(
                            name:'product',
                            titleAttribute: 'id',
                            modifyQueryUsing: fn (Builder $query) => $query->orderBy('code','asc')
                            )
                        ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->code} {$record->textde} {$record->id}"),
                    Forms\Components\TextInput::make('debit')
                            ->label('Soll')
                        ->numeric(),
                    Forms\Components\TextInput::make('credit')
                            ->label('Haben')
                        ->numeric(),
                    Forms\Components\TextInput::make('amount')
                            ->label('Betrag')
                        ->numeric(),
                    Forms\Components\TextInput::make('invoice_number')
                            ->label('Rechnungsnummer')
                        ->numeric(),
                    Forms\Components\TextInput::make('quantity')
                            ->label('Menge')
                        ->numeric(),
                    Forms\Components\TextInput::make('year')
                            ->label('Jahr')
                        ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table

        ->defaultSort(function (Builder $query): Builder {
            return $query
            ->orderBy('year','desc');
            })
            ->recordTitleAttribute('product_id')
          
            ->columns([
               
                Tables\Columns\TextColumn::make('booking')
                    ->date('Y-m-d')
                    ->label('Buchungsdatum'),
                Tables\Columns\TextColumn::make('product.code')
                    ->label('Code'),  
                Tables\Columns\TextColumn::make('product.textde')
                    ->label('Buchung'),
                Tables\Columns\TextColumn::make('debit')
                    ->label('Soll'),
                Tables\Columns\TextColumn::make('credit')
                    ->label('Haben'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Betrag'),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Rechnungsnummer'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Menge'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr'),

            ])
            ->filters([
                // Filter::make('Standard Jahr')->query(
                //     function (Builder $query): Builder {
                //         //return $query->where('year',date("Y"));
                //         return $query->where('year',config('app.year'));
                //     }
                // ) ->label(config('app.year'))->default(),
                Filter::make('Aktuelles_Jahr')->query(
                    function (Builder $query): Builder {
                        return $query->where('year',date("Y"));
                    }
                ) ->label('Aktuelles Jahr')->default(),

                Filter::make('Letztes_Jahr')->query(
                    function (Builder $query): Builder {
                        return $query->where('year',date("Y")-1);
                    }
                ) ->label('Letztes Jahr'),

                Filter::make('Vorletztes_Jahr')->query(
                    function (Builder $query): Builder {
                        return $query->where('year',date("Y")-2);
                    }
                ) ->label('Vorletztes Jahr')
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Neuer Eintrag')
                    ->icon('heroicon-s-plus')
                    ->createAnother(false)
                    ->modalHeading('Neuer Rechnungseintrag'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Rechnung bearbeiten'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
