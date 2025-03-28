<?php

namespace App\Filament\Resources\QualabResource\Pages;

use App\Filament\Resources\QualabResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQualabs extends ListRecords
{
    protected static string $resource = QualabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
