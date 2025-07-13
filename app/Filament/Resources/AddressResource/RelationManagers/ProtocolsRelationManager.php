<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use App\Models\Unit;
use Filament\Tables;
use App\Models\Method;
use App\Models\Survey;
use App\Models\Profile;
use Filament\Forms\Get;
use App\Models\Protocol;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Support\Facades\FilamentToast;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;






class ProtocolsRelationManager extends RelationManager
{
    protected static string $relationship = 'Protocols';
    protected static ?string $title = 'Protokoll-Abo';

    // public static function modifyQueryUsing(Builder $query): Builder
    // {
    //     return $query
    //         ->leftJoin('methods', 'protocols.method_id', '=', 'methods.id')
    //         ->leftJoin('substances', 'methods.substance_id', '=', 'substances.id')
    //         ->leftJoin('products', 'substances.product_id', '=', 'products.id')
    //         ->select('protocols.*', 'products.code as product_code')
    //         ->orderBy('product_code')
    //         ->orderBy('protocols.device_num')
    //         ->orderBy('methods.substancede');
    // }


    public function form(Form $form): Form
    {
        return $form
            ->columns(4)
            ->schema([

                //Forms\Components\TextInput::make('address_id'),
                Forms\Components\TextInput::make('method_id')
                    ->disabled(),


                Placeholder::make('method_info')
                    ->label('Methode')
                    ->content(function ($record) {
                        $number = $record?->method?->number;
                        $sub = $record?->method?->substancede;
                        $instr = $record?->method?->instrumentde;

                        if ($number || $sub || $instr) {
                            $parts = [];

                            if ($number) {
                                $parts[] = "{$number}:";
                            }

                            if ($sub) {
                                $parts[] = $sub;
                            }

                            if ($instr) {
                                $parts[] = $instr;
                            }

                            return implode(' ', [$parts[0] ?? '', implode(', ', array_slice($parts, 1))]);
                        }

                        return 'Nicht verfügbar';
                    }),


                Forms\Components\Select::make('device_id')
                ->label('Zusatzmethode')
                ->columnSpan(2)
                ->options(
                    \App\Models\Device::all()->pluck('textde', 'id')->mapWithKeys(
                        fn ($text, $id) => [$id => "{$text} ({$id})"]
                    )
                )
                ->searchable()
                ->nullable(),

                Forms\Components\TextInput::make('sample_id')
                    ->columnStart(1)
                    ->type('number')
                    ->numeric()
                    ->step(1),

                Select::make('unit_id')
                    ->label('Einheit')
                    ->options(function ($record) {
                        $substanceId = $record?->method?->substance_id;

                        if (!$substanceId) {
                            return [];
                        }

                        return \App\Models\Unit::where('substance_id', $substanceId)
                            ->orderBy('sort')
                            ->get()
                            ->mapWithKeys(fn ($unit) => [
                                $unit->id => optional($unit->unitSymbol)?->textde . " ({$unit->id})",
                            ]);
                    })
                    ->nullable(),




                    
                
                Forms\Components\TextInput::make('device_num')
                    ->columnStart(1)
                    ->label('Gerätenummer')
                    ->maxLength(10)
                    ,
                Forms\Components\TextInput::make('Serialnumber')
                    ->label('Seriennummer')
                    ->maxLength(10),
                Forms\Components\TextInput::make('department')
                    ->label('Abteilung')
                    ->numeric(),
                Forms\Components\TextInput::make('room_num')
                    ->label('Zimmernr')
                    ->nullable() ,    


                Forms\Components\TextInput::make('start_quarter')
                    ->columnStart(1)
                    ->label('Beginn Quartal')
                    ->numeric()
                    ->default(1),

                //Forms\Components\DateTimePicker::make('start_date'),
                Forms\Components\TextInput::make('start_year')
                        
                    ->label('Beginn Jahr')
                    ->default(date('Y'))
                    ->numeric(),

                //Forms\Components\DateTimePicker::make('stop_date'),

                Forms\Components\TextInput::make('stop_quarter')
                    
                ->label('End Quartal')
                    ->columnStart(1)
                    ->numeric()
                    ->default(0),

                Forms\Components\TextInput::make('stop_year')
                    
                    ->label('End Jahr')
                    ->numeric()
                    ->default(0),

            ]);
    }

    public function table(Table $table): Table
    {
        
        
        // Aktuelles Jahr & Quartal aus surveys mit status = 1
        $survey = Survey::where('status', 1)
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->first();

        $currentYear = $survey->year ?? now()->year;
        $currentQuarter = $survey->quarter ?? ceil(now()->month / 3);
        $filterLabel = "Protokolle für {$currentQuarter}-{$currentYear}";
        
        
        
        
        
        
        return $table



            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->join('methods', 'protocols.method_id', '=', 'methods.id')
                    ->join('substances', 'methods.substance_id', '=', 'substances.id')
                    ->join('products', 'substances.product_id', '=', 'products.id') 
                    ->orderBy('products.code')
                    ->orderBy('protocols.device_num')
                    ->orderBy('substances.sort')
                    ->orderBy('substances.textde')
                    ->select('protocols.*');
            })




            ->recordTitleAttribute('method_id')
            
            ->columns([

                Tables\Columns\TextColumn::make('method.substance.product.code')
                    ->label('Probe')
                    ->searchable()
                    ,
                Tables\Columns\TextColumn::make('method.substance.textde')
                    ->label('Substanz')
                    ->sortable(),
                Tables\Columns\TextColumn::make('method.instrument.textde')
                    ->label('Gerät')
                    ->sortable()
                    ->searchable(),    
                Tables\Columns\TextColumn::make('method.number')
                    ->label('Methode NUM')
                    ->sortable(), 
                Tables\Columns\TextColumn::make('method_id')
                    ->label('Methode ID')
                    //->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),     
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

                Tables\Columns\TextColumn::make('start_quarter')
                    ->label('Start Quartal')
                    ,

                Tables\Columns\TextColumn::make('start_year')
                    ->label('Start Jahr')
                ,


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


            Filter::make('AktiveProtokolle')
                ->label($filterLabel)
                ->default()
                ->query(function (Builder $query) use ($currentYear, $currentQuarter) {
                    $query->where(function ($q) use ($currentYear, $currentQuarter) {
                        // Bedingung 1: Keine Enddaten gesetzt
                        $q->where(function ($sub) {
                            $sub->where(function ($x) {
                                $x->whereNull('stop_year')->orWhere('stop_year', 0);
                            })->where(function ($x) {
                                $x->whereNull('stop_quarter')->orWhere('stop_quarter', 0);
                            });
                        })

                        // Bedingung 2: Enddatum liegt in der Zukunft
                        ->orWhere(function ($sub) use ($currentYear, $currentQuarter) {
                            $sub->where('stop_year', '>', $currentYear)
                                ->orWhere(function ($x) use ($currentYear, $currentQuarter) {
                                    $x->where('stop_year', $currentYear)
                                    ->where('stop_quarter', '>=', $currentQuarter);
                                });
                        });
                    });
                })

                // Tables\Filters\Filter::make('Aktuelles Jahr')->query(
                //     function (Builder $query): Builder {
                //         //return $query->where('year',date("Y"));
                //         return $query->where('stop_year',0)->orWhere('stop_year','>=',date("Y"))->orWhereNull('stop_year');
                //     }
                // ) ->label('Aktuelles Jahr')->default(),

                

                // Filter::make('Letztes_Jahr')->query(
                //     function (Builder $query): Builder {
                //         return $query->where('stop_year',date("Y")-1);
                //     }
                // ) ->label('Letztes Jahr'),
            ])
            

            // Ein ganzes Profil für ein bestimmtes Gerät einfügen
            ->headerActions([

                Action::make('Profil hinzufügen')
                    ->label('Profil hinzufügen')
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Select::make('profile_id')
                            ->label('Profil auswählen')
                            ->options(Profile::orderBy('textde')->pluck('textde', 'id'))
                            ->searchable()
                            ->required(),
                    ])

                    ->action(function (array $data, $livewire) {
                        $address = $livewire->ownerRecord;
                        $profile = \App\Models\Profile::findOrFail($data['profile_id']);
                        $methods = $profile->methods;


                        $survey = \App\Models\Survey::where('status', 1)
                            ->orderByDesc('year')
                            ->orderByDesc('quarter')
                            ->first();

                        $currentYear = $survey->year ?? now()->year;
                        $currentQuarter = $survey->quarter ?? ceil(now()->month / 3);



                        $createdCount = 0;

                        foreach ($methods as $method) {
                            // Duplikate vermeiden
                            $exists = \App\Models\Protocol::where('address_id', $address->id)
                                ->where('method_id', $method->id)
                                ->exists();

                            if ($exists) {
                                continue;
                            }

                            // Unit mit sort = 1 für die substance_id suchen
                            $unitId = \App\Models\Unit::where('substance_id', $method->substance_id)
                                ->where('sort', 1)
                                ->value('id');

                            \App\Models\Protocol::create([
                                'address_id' => $address->id,
                                'method_id' => $method->id,
                                'sample_id' => 0,
                                'unit_id' => $unitId,
                                'start_year' => $currentYear,
                                'start_quarter' => $currentQuarter,
                                'stop_year' => 0,
                                'stop_quarter' => 0,
                            ]);

                            $createdCount++;
                        }

                        Notification::make()
                            ->title("{$createdCount} Methoden hinzugefügt")
                            ->success()
                            ->send();
                    })



                    ->requiresConfirmation()
                    ->modalHeading('Methodenprofil einfügen')
                    ->modalSubmitActionLabel('Einfügen'),



            // Die zweite Headeraction mit der eine einzelne Zeile eingefügt wird                
            Action::make('Neue Zeile')
                    ->label('Neue Zeile')
                    ->icon('heroicon-o-plus')
                    
                    ->form([
                    Grid::make(4)->schema([    

                        Select::make('method_id')
                            ->label('Methode')
                            ->columnSpan(2)
                            ->options(
                                \App\Models\Method::query()
                                    ->orderBy('number') // korrektes Feld
                                    ->get()
                                    ->mapWithKeys(function ($method) {
                                        $label = "{$method->number}: {$method->substancede}, {$method->instrumentde}";
                                        return [$method->id => $label];
                                    })
                            )
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('unit_id', null)), 

                        Select::make('device_id')
                            ->columnSpan(2)
                            ->label('Zusatzmethode')
                            ->options(
                                \App\Models\Device::query()
                                    ->orderBy('textde')
                                    ->get()
                                    ->mapWithKeys(fn ($device) => [
                                        $device->id => "{$device->textde} ({$device->id})",
                                    ])
                            )
                            ->searchable()
                            ->nullable(),

                        TextInput::make('sample_id')
                            ->label('Probennummer')
                            ->columnStart(1)
                            ->type('number')
                            ->numeric()
                            ->default(0)
                            ->step(1),


                        Select::make('unit_id')
                            ->label('Einheit')
                            
                            ->options(function (callable $get) {
                                $methodId = $get('method_id');

                                if (!$methodId) {
                                    return [];
                                }

                                $method = \App\Models\Method::find($methodId);
                                $substanceId = $method?->substance_id;

                                if (!$substanceId) {
                                    return ['null' => 'Keine Substanz'];
                                }

                                return \App\Models\Unit::where('substance_id', $substanceId)
                                    ->with('unitSymbol')
                                    ->orderBy('sort')
                                    ->get()
                                    ->mapWithKeys(fn ($unit) => [
                                        $unit->id => optional($unit->unitSymbol)?->textde . " ({$unit->id})",
                                    ]);
                            })
                            ->reactive()
                            ->nullable(),

                
                    Forms\Components\TextInput::make('device_num')
                        ->columnStart(1)
                        ->label('Gerätenummer')
                        ->maxLength(10)
                        ,
                    Forms\Components\TextInput::make('Serialnumber')
                        ->label('Seriennummer')
                        ->maxLength(10),
                    Forms\Components\TextInput::make('department')
                        ->label('Abteilung')
                        ->numeric(),
                    Forms\Components\TextInput::make('room_num')
                        ->label('Zimmernr')
                        ->nullable() ,    


                    TextInput::make('start_quarter')
                        ->numeric()
                        ->default(function () {
                            $survey = \App\Models\Survey::where('status', 1)
                                ->orderByDesc('year')
                                ->orderByDesc('quarter')
                                ->first();

                            return $survey?->quarter ?? ceil(now()->month / 3);
                        })
                        ->columnStart(1),

                    TextInput::make('start_year')
                        ->numeric()
                        ->default(function () {
                            $survey = \App\Models\Survey::where('status', 1)
                                ->orderByDesc('year')
                                ->orderByDesc('quarter')
                                ->first();

                            return $survey?->year ?? now()->year;
                        })
                        ->label('Start Jahr'),
]),


            ])

            
            ->action(function (array $data, $livewire) {
                $address = $livewire->ownerRecord;


                $survey = \App\Models\Survey::where('status', 1)
                    ->orderByDesc('year')
                    ->orderByDesc('quarter')
                    ->first();

                $currentYear = $survey->year ?? now()->year;
                $currentQuarter = $survey->quarter ?? ceil(now()->month / 3);



                \App\Models\Protocol::create([
                    'address_id' => $address->id,
                    'method_id' => $data['method_id'],
                    'sample_id' => $data['sample_id'],
                    'unit_id' => $data['unit_id'],
                    'device_id' => $data['device_id'],
                    'device_num' => $data['device_num'],
                    'room_num' => $data['room_num'],
                    'start_year' => $data['start_year'],
                    'start_quarter' => $data['start_quarter'],
                    'stop_year' => 0,
                    'stop_quarter' => 0,
                ]);

                \Filament\Notifications\Notification::make()
                    ->title('Protokoll hinzugefügt')
                    ->success()
                    ->send();
            })
            ->modalHeading('Manuelles Protokoll hinzufügen')
            //->modalSubmitActionLabel('Speichern')
            //->modalWidth('full')
            //->requiresConfirmation(),
                        
                
                
                
             ])




                 
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('Protokoll - Eintrag bearbeiten'),
                //Tables\Actions\DeleteAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

            ]);
    }
}
