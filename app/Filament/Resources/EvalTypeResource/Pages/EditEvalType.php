<?php

namespace App\Filament\Resources\EvalTypeResource\Pages;

use App\Filament\Resources\EvalTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvalType extends EditRecord
{
    protected static string $resource = EvalTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
