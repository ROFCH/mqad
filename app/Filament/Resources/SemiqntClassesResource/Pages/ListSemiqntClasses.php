<?php

namespace App\Filament\Resources\SemiqntClassesResource\Pages;

use App\Filament\Resources\SemiqntClassesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSemiqntClasses extends ListRecords
{
    protected static string $resource = SemiqntClassesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
