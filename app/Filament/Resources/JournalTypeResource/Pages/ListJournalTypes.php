<?php

namespace App\Filament\Resources\JournalTypeResource\Pages;

use App\Filament\Resources\JournalTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJournalTypes extends ListRecords
{
    protected static string $resource = JournalTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
