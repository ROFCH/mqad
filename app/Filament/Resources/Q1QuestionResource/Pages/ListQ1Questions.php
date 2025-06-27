<?php

namespace App\Filament\Resources\Q1QuestionResource\Pages;

use App\Filament\Resources\Q1QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQ1Questions extends ListRecords
{
    protected static string $resource = Q1QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
