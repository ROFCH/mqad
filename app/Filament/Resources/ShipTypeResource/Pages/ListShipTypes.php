<?php

namespace App\Filament\Resources\ShipTypeResource\Pages;

use App\Filament\Resources\ShipTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShipTypes extends ListRecords
{
    protected static string $resource = ShipTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
