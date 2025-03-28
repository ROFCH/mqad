<?php

namespace App\Filament\Resources\LabTypeResource\Pages;

use App\Filament\Resources\LabTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLabTypes extends ListRecords
{
    protected static string $resource = LabTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
