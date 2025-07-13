<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'Subscriptions';
    protected static ?string $title = 'Bestellungen';

    public function form(Form $form): Form
    {
        $currentSurvey = Survey::where('status', 1)->orderByDesc('id')->first();
        
        return $form
            ->columns(4)
            ->schema([

                Forms\Components\TextInput::make('sample_quantity')
                    ->label('Anzahl')
                    ->default(1),


                Forms\Components\Select::make('product_id')
                        ->optionsLimit(200)
                     ->columnSpan(2)
                     ->label('Probe')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->relationship(
                        name:'product',
                        titleAttribute: 'code',
                        modifyQueryUsing: fn (Builder $query) => $query->where('sample',">",0)->orderBy('code'))
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->code} {$record->textde}"),


                // Forms\Components\Select::make('product_id')
                //     ->optionsLimit(200)
                //     ->label('Probe')
                //     ->columnSpan(2)
                //     ->required()
                //     ->options(Product::where('sample', '>', 0)
                //         ->orderBy('code')
                //         ->get()
                //         ->pluck('code', 'id')) // oder für mehr Info:
                //         // ->mapWithKeys(fn ($product) => [$product->id => "{$product->code} {$product->textde}"])
                //     ->searchable(),


                    Forms\Components\TextInput::make('start_quarter')
                        ->columnStart(1)
                        ->default($currentSurvey?->quarter)
                        ->label('Start Quartal')
                        ->type('number')        // ← erzeugt das Pfeilfeld (Stepper)
                        ->numeric()             // ← für Validierung als Zahl
                        ->minValue(1)
                        ->maxValue(8)           // ← falls du z. B. 1–8 erlaubst
                        ->step(1),     
                // Forms\Components\TextInput::make('start_quarter')
                //         ->columnStart(1)
                //     ->label('Beginn Quartal')
                //     ->default($currentSurvey?->quarter),
                
                
                Forms\Components\TextInput::make('start_year')
                    
                    ->default($currentSurvey?->year)
                    ->label('Beginn Jahr')
                    ->type('number')   
                    ->numeric() 
                    ->step(1),


                Forms\Components\TextInput::make('stop_quarter')
                    ->columnStart(1)
                    ->label('End Quartal')
                    ->placeholder('Quartal')
                    ->numeric()
                    ->default(0)
                    ->type('number')   
                    ->numeric() 
                    ->step(1),  

                Forms\Components\TextInput::make('stop_year')
                    
                    ->label('End Jahr')
                    ->placeholder('Jahr')
                    ->default(0)
                    ->type('number')   
                    ->numeric() 
                    ->step(1),



                Forms\Components\Checkbox::make('free')
                    ->columnStart(1)
                    ->label('gratis'),


            ]);
    }

    public function table(Table $table): Table
    {
        
        
            // Aktuelles Jahr und Quartal aus Surveys holen
            $survey = \App\Models\Survey::where('status', 1)
                ->orderByDesc('year')
                ->orderByDesc('quarter')
                ->first();



            $currentYear = $survey->year ?? now()->year;
            $currentQuarter = $survey->quarter ?? ceil(now()->month / 3);
            $filterLabel = "Anmeldungen für {$currentQuarter}-{$currentYear}";
        
        
        
        
        return $table
            ->recordTitleAttribute('product_id')
            ->defaultSort('product.code', 'asc')
            ->columns([


                Tables\Columns\TextColumn::make('product.code')
                    ->label('Id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.textde')
                    ->label('Probe'),
                Tables\Columns\TextColumn::make('sample_quantity')
                    ->label('Anzahl'),

                Tables\Columns\TextColumn::make('start_quarter')
                    ->label('Start Quartal'),    

                Tables\Columns\TextColumn::make('start_year')
                    ->label('Start Jahr'),

                Tables\Columns\TextInputColumn::make('stop_quarter')
                    ->label('End Quartal')
                    ->placeholder('Quartal'),

                Tables\Columns\TextInputColumn::make('stop_year')
                    ->label('End Jahr')
                    ->placeholder('Jahr'),

                Tables\Columns\CheckboxColumn::make('free')
                    ->label('gratis'),

            ])
            ->filters([
    SelectFilter::make('subscription_status')
        ->label('Bestellungen')
        ->options([
            //'none' => 'Alle Bestellungen',
            'active' => 'Aktive und zukünftige Bestellungen',
            'current' => $filterLabel,
        ])
        ->default('current') // 👈 Standard ist jetzt Filter 3
        ->query(function (Builder $query, array $data) use ($currentYear, $currentQuarter) {
            return match ($data['value']) {
                'active' => $query->where(function ($query) use ($currentYear, $currentQuarter) {
                    $query->where(function ($q) {
                        $q->where('stop_year', 0)
                           ->where('stop_quarter', 0);
                    })->orWhere(function ($q) use ($currentYear, $currentQuarter) {
                        $q->where('stop_year', '>', $currentYear)
                           ->orWhere(function ($q) use ($currentYear, $currentQuarter) {
                               $q->where('stop_year', $currentYear)
                                 ->where('stop_quarter', '>=', $currentQuarter);
                           });
                    });
                }),
                'current' => $query->where(function ($query) use ($currentYear, $currentQuarter) {
                    // Noch gültig
                    $query->where(function ($q) {
                        $q->where('stop_year', 0)
                           ->where('stop_quarter', 0);
                    })->orWhere(function ($q) use ($currentYear, $currentQuarter) {
                        $q->where('stop_year', '>', $currentYear)
                           ->orWhere(function ($q) use ($currentYear, $currentQuarter) {
                               $q->where('stop_year', $currentYear)
                                 ->where('stop_quarter', '>=', $currentQuarter);
                           });
                    });
                })
                ->where(function ($query) use ($currentYear, $currentQuarter) {
                    // Bereits gestartet
                    $query->where('start_year', '<', $currentYear)
                          ->orWhere(function ($q) use ($currentYear, $currentQuarter) {
                              $q->where('start_year', $currentYear)
                                ->where('start_quarter', '<=', $currentQuarter);
                          });
                }),
                default => $query, // kein Filter
            };
        }),
])


            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Neuer Eintrag')
                ->icon('heroicon-s-plus')
                ->modalHeading('Neue Bestellung'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('Bestellung bearbeiten'),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
