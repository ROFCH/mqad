<?php

namespace App\Filament\Resources\ShipFormatResource\Pages;

use App\Filament\Resources\ShipFormatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShipFormat extends EditRecord
{
    protected static string $resource = ShipFormatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
