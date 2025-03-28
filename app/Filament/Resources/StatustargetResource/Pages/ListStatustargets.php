<?php

namespace App\Filament\Resources\StatustargetResource\Pages;

use App\Filament\Resources\StatustargetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatustargets extends ListRecords
{
    protected static string $resource = StatustargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
