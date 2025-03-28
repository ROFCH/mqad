<?php

namespace App\Filament\Resources\PreanalyticResource\Pages;

use App\Filament\Resources\PreanalyticResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPreanalytics extends ListRecords
{
    protected static string $resource = PreanalyticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
