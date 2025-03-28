<?php

namespace App\Filament\Resources\ShipTypeResource\Pages;

use App\Filament\Resources\ShipTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShipType extends EditRecord
{
    protected static string $resource = ShipTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
