<?php

namespace App\Filament\Resources\UnitSymbolResource\Pages;

use App\Filament\Resources\UnitSymbolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnitSymbols extends ListRecords
{
    protected static string $resource = UnitSymbolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
