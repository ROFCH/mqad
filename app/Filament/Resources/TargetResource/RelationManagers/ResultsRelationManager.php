<?php

namespace App\Filament\Resources\TargetResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Exports\ResultExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('method_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('method_num')
                    ->numeric(),
                Forms\Components\Select::make('method_id')
                    ->relationship('method', 'id'),
                Forms\Components\Select::make('unit_id')
                    ->relationship('unit', 'id'),
                Forms\Components\TextInput::make('value')
                    ->numeric(),
                Forms\Components\TextInput::make('additional_value')
                    ->numeric(),
                Forms\Components\TextInput::make('device_num')
                    ->maxLength(10),
                Forms\Components\TextInput::make('device_id')
                    ->numeric(),
                Forms\Components\TextInput::make('serialnumber')
                    ->maxLength(10),
                Forms\Components\TextInput::make('department')
                    ->numeric(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('method_id')
            ->columns([
                
                Tables\Columns\TextColumn::make('address.id')
                    ->label("Teilnehmer")
                    ->sortable(),

                Tables\Columns\TextColumn::make('address_display')
                    ->label('Adresse')
                    ->getStateUsing(function ($record) {
                        $name = trim($record->address->name ?? '');
                        $city = trim($record->address->city ?? '');

                        return $name && $city
                            ? "{$name}, {$city}"
                            : ($name ?: $city ?: '-');
                    }) ,

                // Tables\Columns\TextColumn::make('address.name')
                //     ->label('Name'),    
                
                Tables\Columns\TextColumn::make('value')
                    ->label("Wert")
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 3, '.', '')),

                Tables\Columns\TextColumn::make('unit.unitsymbol.textde')
                    ->label("Einheit"),    

                
                Tables\Columns\TextColumn::make('device_id')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('device.textde')
                    ->label("Zusatzmethode")
                    ->sortable(),    

                Tables\Columns\TextColumn::make('device_num')
                    ->label("Gerätenummer")
                    ->searchable(),

                Tables\Columns\TextColumn::make('additional_value')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('serialnumber')
                    ->label('Seriennummer')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('department')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('staff_id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),  
                Tables\Columns\TextColumn::make('survey_id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),          
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),



            ])
            ->defaultSort('value', 'asc')
            
            ->filters([

                Tables\Filters\SelectFilter::make('survey_id')
                        ->label('Ringversuch')
                        ->options(
                            Survey::all()->mapWithKeys(function ($survey) {
                                return [
                                    $survey->id => "{$survey->year} / Q{$survey->quarter}",
                                ];
                            })
                        )
                        ->default(Survey::where('def_survey', true)->value('id'))
                        ->searchable(),

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                ExportAction::make()->exporter(ResultExporter::class),
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
