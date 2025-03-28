<?php

namespace App\Filament\Resources\StatcodeResource\Pages;

use App\Filament\Resources\StatcodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatcodes extends ListRecords
{
    protected static string $resource = StatcodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
