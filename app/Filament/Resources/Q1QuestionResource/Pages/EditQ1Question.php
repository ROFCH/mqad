<?php

namespace App\Filament\Resources\Q1QuestionResource\Pages;

use App\Filament\Resources\Q1QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQ1Question extends EditRecord
{
    protected static string $resource = Q1QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
