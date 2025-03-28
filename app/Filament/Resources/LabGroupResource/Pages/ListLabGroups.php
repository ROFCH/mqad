<?php

namespace App\Filament\Resources\LabGroupResource\Pages;

use App\Filament\Resources\LabGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLabGroups extends ListRecords
{
    protected static string $resource = LabGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
