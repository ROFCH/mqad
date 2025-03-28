<?php

namespace App\Filament\Resources\SterilizerResource\Pages;

use App\Filament\Resources\SterilizerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSterilizers extends ListRecords
{
    protected static string $resource = SterilizerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
