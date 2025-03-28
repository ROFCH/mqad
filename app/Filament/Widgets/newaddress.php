<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Address;
use Filament\Tables\Table;
use Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class newaddress extends BaseWidget
{

    protected static ?string $heading = 'Neue Teilnehmer';
    protected static ?int $sort = 5;


    public function table(Table $table): Table
    {
        return $table
            ->query(
                Address::orderBy('created_at','desc')->limit(5)
            )
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('city'),
            ]);
    }
}
