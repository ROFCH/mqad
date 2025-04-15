<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use App\Models\Method;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'Results';
    protected static ?string $title = 'Resultate';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                // Forms\Components\TextInput::make('address_id')
                // ->disabled(),


                Forms\Components\Select::make('method_id')
                    ->label('Methodennummer')
                ->relationship('method', 'id')
                ->default(1)
                ->optionsLimit(10000)
                ->preload()
                ->getSearchResultsUsing(fn (string $search): array => Method::where('number', 'like', "%{$search}%")->limit(50)->pluck('number', 'id')->toArray())
                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->number} {$record->substancede} {$record->instrumentde}")
                ->searchable(),

                Forms\Components\Select::make('unit_id')
                    ->label('Einheit')
                ->relationship('unit', 'id')
                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->substance_id} {$record->unit_symobl_id}"),
                
                //->getSearchResultsUsing(fn (string $search): array => Unit::where('substance_id', 'like', 'method.substance.id')->pluck('substance_id', 'unit_symbol_id')->toArray())

                //->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} {$record->unit_symbol_id}"),
                // ->default(1)
                // ->optionsLimit(10000)
                // ->preload()
                // ->getSearchResultsUsing(fn (string $search): array => Unit::where('substance_id', 'like', 'method.substance.id')->pluck('substance_id', 'unit_symbol_id')->toArray())
                // ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->substance_id} {$record->unit_symbol_id}")
                // ->searchable(),


                Forms\Components\TextInput::make('value')
                    ->label('Wert'),

                Forms\Components\select::make('device_id')
                    ->label("Zusatzmethode")
                    ->relationship('device', 'id')
                    ->optionsLimit(100000)
                    ->preload()
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} {$record->textde} "),

                Forms\Components\TextInput::make('additional_value')
                    ->label("Zusatzwert (mm)"),
                Forms\Components\TextInput::make('device_num')
                    ->label("Gerätenummer"),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('address_id')
            ->columns([

            Tables\Columns\TextColumn::make('method.id')
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('method.substance.product.code')
                ->label('Probe')
                ->sortable(),
            Tables\Columns\TextColumn::make('method.substance.textde')
                ->label('Substanz')
                ->sortable(),
            Tables\Columns\TextColumn::make('method.instrument.textde')
                ->label('Gerät')
                ->sortable(),      
                Tables\Columns\TextColumn::make('method.number')
                ->sortable(),      
            Tables\Columns\TextInputColumn::make('value'),  
            Tables\Columns\TextColumn::make('unit.unitsymbol.textde'),

            Tables\Columns\TextColumn::make('additional_value')
                ->numeric()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('device_num')
                ->searchable(),
            Tables\Columns\TextColumn::make('device.textde'),    
            Tables\Columns\TextColumn::make('device_id')
            ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('serialnumber')
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('department')
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('year')
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('quarter')
                 ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('Standard Ringversuch')->query(
                    function (Builder $query): Builder {
                        //return $query->where('year',date("Y"));
                        return $query->where('survey_id',config('app.survey'));
                    }
                ) ->label('Ringversuch '. config('app.survey'))->default(),

                Tables\Filters\SelectFilter::make('Ringversuch')
                    ->relationship('survey','id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->year} - {$record->quarter} ({$record->id})")
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Neuer Eintrag')
                ->icon('heroicon-s-plus')
                ->modalHeading('Neues Resultat'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('Resultat bearbeiten'),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
