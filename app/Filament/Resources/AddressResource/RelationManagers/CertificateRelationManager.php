<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use TextColumn\TextColumnSize;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;

class CertificateRelationManager extends RelationManager
{
    protected static string $relationship = 'Certificates';
    protected static ?string $title = 'Zertifikate';




    public function form(Form $form): Form
    {
        return $form

           
        
            ->schema([

                // Forms\Components\Select::make('address_id')
                //     ->label('Teilnehmer')
                //     ->relationship('address', 'id')
                //     ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} - {$record->name}")
                //     ->disabled(),
                Forms\Components\Select::make('substance_id')
                    ->columnStart(1)
                    ->label('Substanz')
                    ->relationship('substance', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->textde} ({$record->id})"),
                Forms\Components\TextInput::make('success')
                    ->columnStart(1)
                    ->label('Erfolg')
                    ->default(4),
                Forms\Components\TextInput::make('participation')
                    ->label('Teilnahme')
                    ->default(4),
                Forms\Components\TextInput::make('evaluation')
                    ->label('Bewertung')
                    ->maxLength(1)
                    ->default('A'),
                Forms\Components\TextInput::make('year')
                    ->label('Jahr')
                    ->default(date('Y')),




            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('substance_id')
            
            ->columns([
                Tables\Columns\TextColumn::make('substance.product.code')
                    ->label('Probe')
                    ->sortable(),
                Tables\Columns\TextColumn::make('substance.textde')
                    ->label('Substanz'),
                Tables\Columns\TextInputColumn::make('success')
                    ->label('Erfolg')
                    ->type('number')
                    ->mask('99'),
                Tables\Columns\TextInputColumn::make('participation')
                    ->label('Teilnahme'),
                Tables\Columns\TextInputColumn::make('evaluation')
                    ->label('Auswertung')
                ->extraAttributes(['style' => 'max-width: 30px']),
                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr'),
            ])
            ->filters([
                Filter::make('Aktuelles Jahr')->query(
                    function (Builder $query): Builder {
                        //return $query->where('year',date("Y"));
                        return $query->where('year',date("Y"));
                    }
                ) ->label('Aktuelles Jahr'),

                Filter::make('Letztes_Jahr')->query(
                    function (Builder $query): Builder {
                        return $query->where('year',date("Y")-1);
                    }
                ) ->label('Letztes Jahr')->default(),

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
                ->modalHeading('Neuer Zertifikat-Eintrag'),
            ])
            ->actions([
                Tables\Actions\EditAction::make() 
                    ->modalHeading('Zertifikate bearbeiten'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
