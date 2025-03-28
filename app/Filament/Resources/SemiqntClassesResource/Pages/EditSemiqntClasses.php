<?php

namespace App\Filament\Resources\SemiqntClassesResource\Pages;

use App\Filament\Resources\SemiqntClassesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSemiqntClasses extends EditRecord
{
    protected static string $resource = SemiqntClassesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
