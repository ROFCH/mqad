<?php

namespace App\Filament\Resources\EvalTypeResource\Pages;

use App\Filament\Resources\EvalTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvalTypes extends ListRecords
{
    protected static string $resource = EvalTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
