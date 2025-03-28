<?php

namespace App\Filament\Resources\B9targetResource\Pages;

use App\Filament\Resources\B9targetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListB9targets extends ListRecords
{
    protected static string $resource = B9targetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
