<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\SurveyResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class survey extends BaseWidget
{
    protected static ?string $heading = 'Aktuelle Ringversuchsdaten';
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Survey::where('shipping','>',now()))
            ->defaultSort('created_at', 'desc')
            ->DefaultPaginationPageOption(1)
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('quarter')
                    ->label('Quartal'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr'),

                Tables\Columns\TextColumn::make('shipping')
                    ->label('Versanddatum')
                    ->date('D d m Y')    ,
                                    Tables\Columns\TextColumn::make('closing')
                    ->label('Einsendeschluss')
                    ->date('D d m Y')    , 
                Tables\Columns\TextColumn::make('replacementdate')
                    ->label('Ersatztermin')
                    ->date('D d m Y')    ,
                Tables\Columns\TextColumn::make('reminder')
                    ->label('Einreichen nach Mahnung')
                    ->date('D d m Y')    ,
   
                Tables\Columns\TextColumn::make('end')
                    ->label('Abschluss Ringversuch')
                    ->date('D d m Y')    ,
            ]);
    }
}
