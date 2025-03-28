<?php

namespace App\Filament\Resources\StatmethodResource\Pages;

use App\Filament\Resources\StatmethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatmethods extends ListRecords
{
    protected static string $resource = StatmethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
