<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use App\Models\Unit;
use Filament\Tables;
use App\Models\Method;
use App\Models\Survey;
use App\Models\Target;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Grid;

use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;

use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;


class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'Results';
    protected static ?string $title = 'Resultate';



public function form(Form $form): Form
{
    return $form
        ->columns(4)
        ->schema([


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
                    ->placeholder('')
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
                    
                    // ->default(function (callable $get) {
                    //     $methodId = $get('method_id');
                    //     $method = \App\Models\Method::find($methodId);
                    //     $substanceId = $method?->substance_id;

                    //     return \App\Models\Unit::where('substance_id', $substanceId)
                    //         ->orderBy('sort')
                    //         ->value('id'); // 👈 liefert nur die ID des ersten Treffers
                    // })
                    


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


            Forms\Components\TextInput::make('value')
                ->label('Wert')
                ->numeric()
                ->reactive()
                ->nullable(),

            // Forms\Components\Placeholder::make('tolerance_comment')
            //     ->label('Toleranzprüfung')
            //     ->content(function (callable $get) {
            //         $value = $get('value');
            //         $methodId = $get('method_id');
            //         $sampleId = $get('sample_id');
            //         $surveyId = $get('survey_id');

            //         if (!is_numeric($value) || !$methodId || !$sampleId || !$surveyId) {
            //             return '⚠️ Unvollständige Angaben';
            //         }

            //         $target = \App\Models\Target::where('method_id', $methodId)
            //             ->where('sample_id', $sampleId)
            //             ->where('survey_id', $surveyId)
            //             ->first();

            //         if (!$target) {
            //             return '⚠️ Kein Zielwert gefunden';
            //         }

            //         $mean = $target->mean;
            //         $tolerance = $target->effective_toleranceabs;

            //         if (!is_numeric($mean) || !is_numeric($tolerance)) {
            //             return '⚠️ Ungültige Zielwertdaten';
            //         }

            //         $diff = abs($value - $mean);

            //         return $diff <= $tolerance
            //             ? '✅ Innerhalb der Toleranz'
            //             : "❌ Abweichung: {$diff} > Toleranz: {$tolerance}";
            //     }),

            
            Forms\Components\TextInput::make('additional_value')
                ->label("Zusatzwert (mm)"),


        ]);
}


    public function table(Table $table): Table
    {
        return $table


            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->join('methods', 'results.method_id', '=', 'methods.id')
                    ->join('substances', 'methods.substance_id', '=', 'substances.id')
                    ->join('products', 'substances.product_id', '=', 'products.id') 
                    ->orderBy('products.code')
                    ->orderBy('results.device_num')
                    ->orderBy('substances.sort')
                    ->orderBy('substances.textde')
                    ->select('results.*');
            })




            ->recordTitleAttribute('address_id')
            ->columns([

            Tables\Columns\TextColumn::make('method.id')
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('method.substance.product.code')
                ->label('Probe')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('sample_id')
                ->label('Probe'), 
            Tables\Columns\TextColumn::make('method.substance.textde')
                ->label('Substanz')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('method.instrument.textde')
                ->label('Gerät')
                ->sortable(),      
                Tables\Columns\TextColumn::make('method.number')
                ->sortable(),      
            
Tables\Columns\TextInputColumn::make('value')
    ->label('Wert')

->extraInputAttributes([
    'x-on:focus' => <<<'JS'
        event.target.style.backgroundColor = '#d1fae5';
        event.target.style.color = '#065f46';
        event.target.style.border = '1px solid #10b981';
    JS,
    'x-on:blur' => <<<'JS'
        event.target.style.backgroundColor = '';
        event.target.style.color = '';
        event.target.style.border = '';
    JS,
])

    
    ->extraAttributes([


        'x-on:focus' => 'setTimeout(() => event.target.select(), 10)',

        'x-on:keydown.enter' => <<<'JS'
            const inputs = Array.from(document.querySelectorAll('input[x-model="state"]'));
            const index = inputs.indexOf(event.target);

            if (index !== -1 && index + 1 < inputs.length) {
                // Normale Navigation
                event.preventDefault();
                event.stopImmediatePropagation();
                inputs[index + 1].focus();
                setTimeout(() => inputs[index + 1].select(), 10);
            } else if (index === inputs.length - 1) {
                // Letztes Feld: Seite wechseln
                event.preventDefault();
                event.stopImmediatePropagation();

                const nextBtn = document.querySelector('button[aria-label="Nächste"]');
                if (nextBtn) {
                    nextBtn.click();

                    let attempts = 0;
                    const maxAttempts = 20;

                    const waitForInput = setInterval(() => {
                        const newInputs = Array.from(document.querySelectorAll('input[x-model="state"]'));

                        if (newInputs.length > 0) {
                            const first = newInputs[0];
                            first.focus();
                            setTimeout(() => first.select(), 10);
                            clearInterval(waitForInput);
                        }

                        if (++attempts > maxAttempts) {
                            clearInterval(waitForInput);
                        }
                    }, 100);
                }
            }
        JS,

        'x-on:keydown.arrow-down' => <<<'JS'
            const inputs = Array.from(document.querySelectorAll('input[x-model="state"]'));
            const index = inputs.indexOf(event.target);

            if (index !== -1 && index + 1 < inputs.length) {
                event.preventDefault();
                event.stopImmediatePropagation();
                inputs[index + 1].focus();
                setTimeout(() => inputs[index + 1].select(), 10);
            } else if (index === inputs.length - 1) {
                event.preventDefault();
                event.stopImmediatePropagation();

                const nextBtn = document.querySelector('button[aria-label="Nächste"]');
                if (nextBtn) {
                    nextBtn.click();

                    let attempts = 0;
                    const maxAttempts = 20;

                    const waitForInput = setInterval(() => {
                        const newInputs = Array.from(document.querySelectorAll('input[x-model="state"]'));

                        if (newInputs.length > 0) {
                            const first = newInputs[0];
                            first.focus();
                            setTimeout(() => first.select(), 10);
                            clearInterval(waitForInput);
                        }

                        if (++attempts > maxAttempts) {
                            clearInterval(waitForInput);
                        }
                    }, 100);
                }
            }
        JS,

        'x-on:keydown.arrow-up' => <<<'JS'
            const inputs = Array.from(document.querySelectorAll('input[x-model="state"]'));
            const index = inputs.indexOf(event.target);

            if (index > 0) {
                event.preventDefault();
                event.stopImmediatePropagation();
                inputs[index - 1].focus();
                setTimeout(() => inputs[index - 1].select(), 10);
            }
        JS,
        ]),





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
            // ->defaultSort('survey_id', 'desc')
            // ->defaultSort('address_id', 'asc')
            ->filters([
                

                SelectFilter::make('survey_id')
    ->label('Ringversuch')
    ->options(function () {
        return Survey::where('status', 1)
            ->orderByDesc('id')
            ->get()
            ->mapWithKeys(function ($survey) {
                $label = "{$survey->quarter}-{$survey->year} (RV{$survey->id})";
                return [$survey->id => $label];
            });
    })
    ->default(function () {
        return Survey::where('status', 1)
            ->orderByDesc('id')
            ->value('id');
    })
                
                

            ])
->headerActions([



Action::make('createResultEntry')
    ->label('Neuen Eintrag')
    ->icon('heroicon-m-plus')
    ->form([
        Grid::make(4)->schema([

            Select::make('method_id')
                ->label('Methode')
                ->columnSpan(2)
                ->options(
                    \App\Models\Method::query()
                        ->orderBy('number')
                        ->get()
                        ->mapWithKeys(function ($method) {
                            $label = "{$method->number}: {$method->substancede}, {$method->instrumentde}";
                            return [$method->id => $label];
                        })
                )
                ->searchable()
                ->reactive()
                ->required()
                ->afterStateUpdated(fn (callable $set) => $set('unit_id', null)),

            Select::make('device_id')
                ->label('Zusatzmethode')
                ->columnSpan(2)
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
                ->numeric()
                ->default(0)
                ->step(1),

            Select::make('unit_id')
                ->label('Einheit')
                ->options(function (callable $get) {
                    $methodId = $get('method_id');
                    if (!$methodId) return [];

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

            TextInput::make('device_num')
                ->columnStart(1)
                ->label('Gerätenummer')
                ->maxLength(10),

            TextInput::make('Serialnumber')
                ->label('Seriennummer')
                ->maxLength(10),

            TextInput::make('department')
                ->label('Abteilung')
                ->numeric(),

            TextInput::make('room_num')
                ->label('Zimmernr')
                ->nullable(),

            TextInput::make('value')
                ->label('Wert')
                ->numeric()
                ->nullable()
                ->columnSpan(2),

            TextInput::make('additional_value')
                ->label('Zusatzwert')
                ->numeric()
                ->nullable()
                ->columnSpan(2),
        ]),
    ])
    ->action(function (array $data, $livewire) {
        $addressId = $livewire->ownerRecord->id;
        $surveyId = $livewire->tableFilters['survey_id']['value'] ?? null;

        if (! $surveyId) {
            Notification::make()
                ->title('Kein Ringversuch ausgewählt')
                ->danger()
                ->send();
            return;
        }

        $survey = DB::table('surveys')
            ->where('id', $surveyId)
            ->select('year', 'quarter')
            ->first();

        if (! $survey) {
            Notification::make()
                ->title('Ringversuch nicht gefunden')
                ->danger()
                ->send();
            return;
        }

        DB::table('results')->insert([
            'address_id'       => $addressId,
            'survey_id'        => $surveyId,
            'method_id'        => $data['method_id'],
            'unit_id'          => $data['unit_id'],
            'device_id'        => $data['device_id'] == 0 ? null : $data['device_id'],
            'device_num'       => $data['device_num'],
            'serialnumber'     => $data['Serialnumber'],
            'department'       => $data['department'],
            'room_num'         => $data['room_num'],
            'sample_id'        => $data['sample_id'],
            'value'            => $data['value'],
            'additional_value' => $data['additional_value'],
            'year'             => $survey->year,
            'quarter'          => $survey->quarter,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        Notification::make()
            ->title('Eintrag erstellt')
            ->body('Der Ergebnis-Eintrag wurde erfolgreich gespeichert.')
            ->success()
            ->send();
    }),


Tables\Actions\Action::make('createResultsFromProtocols')
    ->label(function () {
        $survey = \App\Models\Survey::where('status', 1)
            ->orderByDesc('id')
            ->first();

        if (!$survey) {
            return 'Protokoll (kein aktiver Survey)';
        }

        return "Protokoll {$survey->quarter}-{$survey->year} (RV{$survey->id})";
    })
    ->icon('heroicon-o-plus-circle')
    ->requiresConfirmation()
    ->modalHeading('Protokoll-Einträge übernehmen')
    ->modalSubmitActionLabel('Erstellen')
    ->modalCancelActionLabel('Abbrechen')
    ->modalDescription(function ($livewire) {
        $latestSurvey = \App\Models\Survey::where('status', 1)
            ->orderByDesc('id')
            ->first();

        if (!$latestSurvey) {
            return 'Kein aktiver Survey gefunden.';
        }

        $surveyTime = $latestSurvey->year * 10 + $latestSurvey->quarter;
        $addressId = $livewire->ownerRecord->id;

        $protocols = \App\Models\Protocol::query()
            ->where('address_id', $addressId)
            ->whereRaw('(start_year * 10 + start_quarter) <= ?', [$surveyTime])
            ->where(function ($query) use ($surveyTime) {
                $query->where(function ($q) {
                    $q->where('stop_year', 0)
                        ->where('stop_quarter', 0);
                })
                ->orWhereRaw('(stop_year * 10 + stop_quarter) > ?', [$surveyTime]);
            })
            ->get();

        if ($protocols->isEmpty()) {
            return 'Es wurden keine passenden Protokolleinträge gefunden.';
        }

        return $protocols->map(function ($p) {
            return "- Methode: {$p->method_id}, Probe: {$p->sample_id}, Einheit: {$p->unit_id}";
        })->implode("\n");
    })
    ->action(function ($livewire) {
        $latestSurvey = \App\Models\Survey::where('status', 1)
            ->orderByDesc('id')
            ->first();

        if (!$latestSurvey) {
            \Filament\Notifications\Notification::make()
                ->title('Kein aktiver Survey gefunden')
                ->danger()
                ->send();
            return;
        }

        $surveyTime = $latestSurvey->year * 10 + $latestSurvey->quarter;
        $addressId = $livewire->ownerRecord->id;

        $protocols = \App\Models\Protocol::query()
            ->where('address_id', $addressId)
            ->whereRaw('(start_year * 10 + start_quarter) <= ?', [$surveyTime])
            ->where(function ($query) use ($surveyTime) {
                $query->where(function ($q) {
                    $q->where('stop_year', 0)
                        ->where('stop_quarter', 0);
                })
                ->orWhereRaw('(stop_year * 10 + stop_quarter) > ?', [$surveyTime]);
            })
            ->get();

        $created = 0;

        foreach ($protocols as $protocol) {
            \App\Models\Result::create([
                'survey_id'     => $latestSurvey->id,
                'address_id'    => $protocol->address_id,
                'method_id'     => $protocol->method_id,
                'sample_id'     => $protocol->sample_id,
                'unit_id'       => $protocol->unit_id,
                'device_id'     => $protocol->device_id,
                'device_num'    => $protocol->device_num,
                'serialnumber'  => $protocol->serialnumber,
                'department'    => $protocol->department,
                'room_num'      => $protocol->room_num,
            ]);
            $created++;
        }

        \Filament\Notifications\Notification::make()
            ->title("{$created} Ergebnisse erstellt")
            ->success()
            ->send();
    }),


    // Resinprot Atcion

 Action::make('resinprot')
            ->label('Protokolle automatisch ergänzen')
            ->icon('heroicon-m-plus')
            ->modalHeading('Protokolle automatisch ergänzen')
            ->modalDescription('Fehlende Protokolleinträge werden automatisch eingefügt – bestehende bleiben unverändert.')
            ->modalSubmitActionLabel('Erstellen')
            ->modalCancelActionLabel('Abbrechen')
            ->requiresConfirmation()
            ->action(function ($livewire) {
                $addressId = $livewire->ownerRecord->id;
                $surveyId = $livewire->tableFilters['survey_id']['value'] ?? null;

                if (! $surveyId) {
                    Notification::make()
                        ->title('Kein Ringversuch ausgewählt')
                        ->danger()
                        ->send();
                    return;
                }

                $survey = DB::table('surveys')
                    ->where('id', $surveyId)
                    ->select('year', 'quarter')
                    ->first();

                if (! $survey) {
                    Notification::make()
                        ->title('Ringversuch nicht gefunden')
                        ->danger()
                        ->send();
                    return;
                }

                $results = DB::table('results')
                    ->where('address_id', $addressId)
                    ->where('survey_id', $surveyId)
                    ->get();

                $protocols = DB::table('protocols')
                    ->where('address_id', $addressId)
                    ->get();

                $insertCount = 0;

                foreach ($results as $res) {
                    $alreadyExists = $protocols->contains(function ($proto) use ($res, $survey) {
                        $protoDevice = trim((string) ($proto->device_num ?? ''));
                        $resultDevice = trim((string) ($res->device_num ?? ''));

                        if ($proto->method_id != $res->method_id) {
                            return false;
                        }

                        if ($protoDevice !== $resultDevice) {
                            return false;
                        }

                        $start = ($proto->start_year * 10) + ($proto->start_quarter ?: 1);
                        $stop = ($proto->stop_year > 0 ? $proto->stop_year : 9999) * 10
                              + ($proto->stop_quarter > 0 ? $proto->stop_quarter : 4);

                        $current = ($survey->year * 10) + $survey->quarter;

                        return $current >= $start && $current <= $stop;
                    });

                    if (! $alreadyExists) {
                        DB::table('protocols')->insert([
                            'address_id'     => $addressId,
                            'method_id'      => $res->method_id,
                            'device_num'     => $res->device_num,
                            'unit_id'        => $res->unit_id,
                            'device_id'      => $res->device_id == 0 ? null : $res->device_id,
                            'Serialnumber'   => $res->serialnumber,
                            'department'     => $res->department,
                            'room_num'       => $res->room_num,
                            'start_year'     => $survey->year,
                            'start_quarter'  => $survey->quarter,
                            'stop_year'      => 0,
                            'stop_quarter'   => 0,
                            'created_at'     => now(),
                            'updated_at'     => now(),
                        ]);

                        $insertCount++;
                    }
                }

                Notification::make()
                    ->title('Protokolle ergänzt')
                    ->body("{$insertCount} neue Protokolleinträge wurden erstellt.")
                    ->success()
                    ->send();
            })





])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()
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
