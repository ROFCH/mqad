<?php

namespace App\Filament\Resources\B9protocolResource\Pages;

use App\Filament\Resources\B9protocolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListB9protocols extends ListRecords
{
    protected static string $resource = B9protocolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
