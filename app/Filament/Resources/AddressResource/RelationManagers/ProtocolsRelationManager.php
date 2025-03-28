<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use App\Models\Unit;
use Filament\Tables;
use App\Models\Method;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ProtocolsRelationManager extends RelationManager
{
    protected static string $relationship = 'Protocols';
    protected static ?string $title = 'Protokoll-Abo';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                // Forms\Components\Select::make('method_id')
                // ->relationship('method', 'id')
                // ->default(1)
                // ->optionsLimit(10000)
                // ->preload()
                // ->getSearchResultsUsing(fn (string $search): array => Method::where('number', 'like', "%{$search}%")->limit(50)->pluck('number', 'id')->toArray())
                // ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->number} {$record->substancede} {$record->instrumentde}")
                // ->searchable()
                // ->live(),
                
                // Forms\Components\select::make('unit_id')
                //     ->relationship('unit', 'textde', fn ($query) => $query->with('unitsymbol'))
                //     ->optionsLimit(100000)
                //     ->preload()
                //     ->searchable()
                //     ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id}  {$record->UnitSymbol->textde} "),

                // Forms\Components\select::make('unit_id')
                // ->options(fn (Get $get): Collection => unit::query()
                //     ->where('unit_id', $get('unit_id'))
                //     ->pluck('substancede', 'id')                )
                // ->searchable()
                // ->preload()
                // ->required(),

                Forms\Components\Select::make('method_id')
                    ->label('Methodennummer')
                    ->preload()
                    ->optionsLimit(10000)
                    ->searchable()
                    ->relationship('method','number',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('number', 'asc'))
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->number}  ({$record->id}) - {$record->substancede} "),

                // Forms\Components\Select::make('unit_id')
                //     ->options(fn (Get $get): Collection => Unit::query()
                //         ->where('methods', fn (Builder $query) => $query->where('method.id', $get('method_id')))
                //         ->pluck('substancede','id')),
                    
                // Forms\Components\Select::make('unit_id')
                //     ->preload()
                //     ->relationship(
                //         name: 'unit',
                //         titleAttribute: 'id',
                //         modifyQueryUsing: fn (Builder $query, Get $get) => $query
                //             ->when(value: $get(path: 'method_id') != '', function (Builder $query) use ($get){
                //                 $query->whereHas(relation: 'method', fn (Builder $query)=>$query   
                //                     ->where(column: 'method.substancede', $get(path: 'method_id')));
                //             })
                //             ->active(),
                //         ),


                // Select::make('unit_id')
                // ->searchable()
                // ->preload()
                // ->relationship(
                //     name: 'unit',
                //     titleAttribute: 'id',
                //     modifyQueryUsing: fn (
                //         Builder $query,
                //         Get $get
                //     ) => $query
                //         ->when($get('method_id') != '', function (
                //             Builder $query
                //         ) use ($get) {
                //             $query->whereHas(
                //                 'methods',
                //                 fn (Builder $query) => $query->where(
                //                     'methods.id',
                //                     $get('method_id')
                //                 )
                //             );
                //         })
                //         ->active()
                // ),




                Forms\Components\Select::make('device_id')
                    ->label('Zusatzmethode')
                    ->preload()
                    ->optionsLimit(10000)
                    ->searchable()
                    ->relationship('device','textde',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('textde', 'asc'))
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->textde}  ({$record->id}) ")
                    ->nullable(),
                
                Forms\Components\TextInput::make('device_num')
                    ->label('Gerätenummer')
                    ->maxLength(10),
                Forms\Components\TextInput::make('Serialnumber')
                    ->label('Seriennummer')
                    ->maxLength(10),
                Forms\Components\TextInput::make('department')
                    ->label('Abteilung')
                    ->numeric(),
                //Forms\Components\DateTimePicker::make('start_date'),
                Forms\Components\TextInput::make('start_year')
                    ->label('Beginn Jahr')
                    ->default(date('Y')),
                Forms\Components\TextInput::make('start_quarter')
                    ->label('Beginn Quartal')
                    ->numeric(),
                //Forms\Components\DateTimePicker::make('stop_date'),
                Forms\Components\TextInput::make('stop_year')
                    ->label('End Jahr')
                    ->numeric(),
                Forms\Components\TextInput::make('stop_quarter')
                    ->label('End Quartal')
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table

            //  ->defaultSort(function (Builder $query): Builder {
            //      return $query
            //      ->orderBy('method_id','asc');
            //      //->orderBy('method.substance.textde','asc');
            //      })

            ->defaultSort('method.substance.product.code','asc')
            ->recordTitleAttribute('method_id')
            ->columns([

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
                    ->label('Methode')
                    ->sortable(), 
                Tables\Columns\TextColumn::make('device.textde')
                    ->label('Zusatzmethode'),
                Tables\Columns\TextColumn::make('device_num')
                    ->toggleable(isToggledHiddenByDefault: true),     
                Tables\Columns\TextColumn::make('unit.unitSymbol.textde')
                    ->label('Einheit'),

                Tables\Columns\TextColumn::make('Serialnumber')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('department')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('start_date')
                //     ->date('Y-m-d')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('start_year')
                    ->label('Start')
                ->sortable(),
                Tables\Columns\TextColumn::make('start_quarter')
                    ->label('Start')
                    ->sortable(),

                // Tables\Columns\TextColumn::make('stop_date')
                //     ->date('Y-m-d')
                //     ->sortable(),
                Tables\Columns\TextInputColumn::make('stop_year')
                    ->label('End Jahr'),
                Tables\Columns\TextInputColumn::make('stop_quarter')
                    ->label('End Quartal'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

                Tables\Filters\Filter::make('Aktuelles Jahr')->query(
                    function (Builder $query): Builder {
                        //return $query->where('year',date("Y"));
                        return $query->where('stop_year',0)->orWhere('stop_year','>=',date("Y"))->orWhereNull('stop_year');
                    }
                ) ->label('Aktuelles Jahr')->default(),

                

                Filter::make('Letztes_Jahr')->query(
                    function (Builder $query): Builder {
                        return $query->where('stop_year',date("Y")-1);
                    }
                ) ->label('Letztes Jahr'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Neuer Eintrag')
                ->icon('heroicon-s-plus')
                ->modalHeading('Neuer Protokoll-Eintrag'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Protokoll-Eintrag bearbeiten'),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
