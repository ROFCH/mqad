<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'Schedules';
    protected static ?string $title = 'Ersatz- und Spezialtermine';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('schedule_type_id')
                    ->label('Termintyp')
                    ->required()
                    ->preload()
                    ->relationship(
                        name:'schedule_type',
                        titleAttribute: 'textde',
                        )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} {$record->textde}"),   
                Forms\Components\Select::make('survey_id')
                    ->label('Ringversuch')
                    ->required()
                    ->preload()
                    ->relationship(
                        name:'survey',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('year','desc')
                        )
                     ->getOptionLabelFromRecordUsing(fn (Model $record) => " {$record->year} - {$record->quarter}  ({$record->id}) "),    
                Forms\Components\TextInput::make('year')
                    ->label('Jahr')
                    ->required(),
                Forms\Components\TextInput::make('quarter')
                    ->label('Quartal')
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('schedule_type_id')
            ->columns([
                Tables\Columns\TextColumn::make('schedule_type.textde')
                    ->label('Termin'),
                //Tables\Columns\TextColumn::make('schedule_type_id'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr'),
                Tables\Columns\TextColumn::make('quarter')
                    ->label('Quartal'),
                Tables\Columns\TextColumn::make('survey_id')
                    ->label('Ringversuch'),
                Tables\Columns\TextColumn::make('remark')
                    ->label('Bemerkungen'),
            ])
            ->filters([
                    Filter::make('Aktuelles Jahr')->query(
                        function (Builder $query): Builder {
                            //return $query->where('year',date("Y"));
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
                ->modalHeading('Neuer Ersatztermin'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('Ersatztermin bearbeiten'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
