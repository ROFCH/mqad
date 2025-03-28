<?php

namespace App\Filament\Resources\RefdataResource\Pages;

use App\Filament\Resources\RefdataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefdatas extends ListRecords
{
    protected static string $resource = RefdataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
