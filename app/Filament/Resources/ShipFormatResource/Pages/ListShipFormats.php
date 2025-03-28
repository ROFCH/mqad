<?php

namespace App\Filament\Resources\ShipFormatResource\Pages;

use App\Filament\Resources\ShipFormatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShipFormats extends ListRecords
{
    protected static string $resource = ShipFormatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
