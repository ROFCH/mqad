<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use App\Models\Target;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Exports\TargetExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TargetResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TargetResource\RelationManagers;

class TargetResource extends Resource
{
    protected static ?string $model = Target::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationLabel = 'Zielwerte';
    protected static ?string $navigationGroup = 'Zielwerte';

    protected static ?string $pluralModelLabel = 'Zielwerte';
    protected static ?string $modelLabel = 'Zielwert';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(11)
            ->schema([
                // Forms\Components\Select::make('method_id')
                //     ->relationship('method', 'id'),
                Forms\Components\TextInput::make('method_id')
                    ->label('Methoden - ID')
                    ->numeric(),  

                Forms\Components\TextInput::make('sample_id')
                    ->label('Probennummer')
                    ->numeric(),    
                Forms\Components\TextInput::make('method_num')
                    ->label('Methodennummer')
                    ->numeric(),
                Forms\Components\TextInput::make('substancede')
                    ->label('Substanzinfo')
                    ->maxLength(50),
                Forms\Components\TextInput::make('instrumentde')
                    ->label('Substanzinfo')
                    ->maxLength(50),
                Forms\Components\TextInput::make('statustarget_id')
                    ->helperText('>=4 wird nicht mehr berechnet')
                    ->numeric(),    
                // Forms\Components\Select::make('statustarget')
                //     ->columnStart(1)
                //     ->columnSpan(2)
                //     ->label('Status')
                //     ->relationship('statustarget', 'textde'),
                Forms\Components\TextInput::make('value')
                    ->columnStart(1)
                    ->label('Prov Zielwert')
                    ->columnstart(1)
                    ->numeric(),
                Forms\Components\TextInput::make('mean')
                    ->label('Zielwert')
                    ->helperText('Zielwert, kann verändert werden')

                    ->numeric(),
                Forms\Components\TextInput::make('effective_toleranceabs')
                    ->label('Abweichung')
                    ->helperText('Absolute Abweichung, kann verändert werden')
                    ->numeric(),
 
                Forms\Components\TextInput::make('code')
                    ->helperText('Alle richtigen Codes, durch Kommas getrennt')
                    ->columnstart(1)
                    ->columnspan(3)
                    ->maxLength(50),    
                Forms\Components\TextInput::make('total')
                    ->label('Alle')
                    ->columnstart(1)
                    ->numeric(),
                Forms\Components\TextInput::make('count1')
                    ->label('sehr gut')
                    ->numeric(),
                Forms\Components\TextInput::make('count2')
                    ->label('gut')
                    ->numeric(),
                Forms\Components\TextInput::make('count3')
                    ->label('ungenügend')
                    ->numeric(),
                Forms\Components\TextInput::make('count4')
                    ->label('Ausreisser')
                    ->numeric(),

                Forms\Components\TextInput::make('sum')
                    ->numeric(),
                Forms\Components\TextInput::make('l1')
                    ->label('Anzahl Negativ')
                    ->columnstart(1)
                    ->numeric(),
                Forms\Components\TextInput::make('l2')
                    ->label('Anzahl Positiv')
                    ->numeric(),
                Forms\Components\TextInput::make('l3')
                    ->label('Anzahl Grenzwertig')
                    ->numeric(),
                Forms\Components\TextInput::make('lg')
                    ->label('Total Werte')
                    ->numeric(),
                Forms\Components\TextInput::make('lt1')
                    ->label('Total Negativ pro Substanz')
                    ->numeric(),
                Forms\Components\TextInput::make('lt2')
                    ->label('Total Positiv pro Substanz')
                    ->numeric(),
                Forms\Components\TextInput::make('lt3')
                    ->label('Total Grenz. pro Substanz')
                    ->numeric(),

                Forms\Components\TextInput::make('sq1')
                    ->columnstart(1)
                    ->numeric(),
                Forms\Components\TextInput::make('sq2')
                    ->numeric(),
                Forms\Components\TextInput::make('sq3')
                    ->numeric(),
                Forms\Components\TextInput::make('sq4')
                    ->numeric(),
                Forms\Components\TextInput::make('sq5')
                    ->numeric(),
                Forms\Components\TextInput::make('sq6')
                    ->numeric(),
                Forms\Components\TextInput::make('sq7')
                    ->numeric(),
                Forms\Components\TextInput::make('sq8')
                    ->numeric(),
                Forms\Components\TextInput::make('sq9')
                    ->numeric(),
                Forms\Components\TextInput::make('sq10')
                    ->numeric(),    
                Forms\Components\TextInput::make('sq11')
                    ->numeric(),    
                Forms\Components\TextInput::make('autp')
                    ->label('Typ der Auswertung 1=qnt, 2=qlt, 3=sqnt')
                    ->numeric(),
              

                Forms\Components\TextInput::make('fmit')
                    ->numeric(),


                Forms\Components\TextInput::make('points')
                    ->numeric(),

                
                // Forms\Components\TextInput::make('quarter')
                //     ->label('Quarter')
                //     ->columnstart(1)
                //     ->numeric(),
                // Forms\Components\TextInput::make('year')
                //     ->label('Jahr')
                //     ->numeric(),

                Forms\Components\TextInput::make('survey_id')
                    ->label('Ringversuchs ID')
                    ->numeric(),
                Forms\Components\TextInput::make('beme')
                    ->label('Bemerkungen')
                    ->columnstart(1)
                    ->columnspan(4)
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultSort('method_num', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('method_id')
                    ->label('Methodenindex')
                    ->sortable()
                    ->searchable(isIndividual: true)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('method_num')
                    ->label('Methodennummer')
                    ->sortable()
                    //->searchable(isIndividual: true)
                    ->toggleable(isToggledHiddenByDefault: true),   
                Tables\Columns\TextColumn::make('method.substance.product.code')
                    ->label('Ringversuch')
                    ->searchable(),
                       
                Tables\Columns\TextColumn::make('sample_id')
                    ->searchable(isIndividual: true)
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),

                 
                Tables\Columns\TextColumn::make('substancede')
                    ->label('Substanz')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instrumentde')
                    ->label('Gerät')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('value')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextInputColumn::make('mean')
                    ->label('Zielwert'),
                Tables\Columns\TextInputColumn::make('code'),    
                Tables\Columns\TextColumn::make('effective_toleranceabs')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('statustarget.textde'),       
                // Tables\Columns\TextColumn::make('total')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('count1')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('count2')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('count3')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('count4')
                //     ->numeric()
                //     ->sortable(),

                // Tables\Columns\TextColumn::make('sum')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('l1')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('l2')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('l3')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('lg')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('lt1')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('lt2')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('lt3')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('stat')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq1')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq2')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq3')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq4')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq5')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq6')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq7')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq8')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq9')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq10')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sq11')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('autp')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('beme')
                //     ->searchable(),

                // Tables\Columns\TextColumn::make('fmit')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('points')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('survey_id')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                // Tables\Filters\Filter::make('Standard Ringversuch')->query(
                //     function (Builder $query): Builder {
                //         //return $query->where('year',date("Y"));
                //         return $query->where('survey_id',config('app.survey'));
                //     }
                // ) ->label('Ringversuch '. config('app.survey'))->default(),

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



                // Tables\Filters\SelectFilter::make('Ringversuch')
                //     ->relationship('survey','id')
                //     ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->year} - {$record->quarter} ({$record->id})")
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->headerActions([
                ExportAction::make()->exporter(TargetExporter::class)
        ])


            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //

            RelationManagers\ResultsRelationManager::class,  
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTargets::route('/'),
            'create' => Pages\CreateTarget::route('/create'),
            'edit' => Pages\EditTarget::route('/{record}/edit'),
        ];
    }
}
