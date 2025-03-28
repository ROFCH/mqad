<?php

namespace App\Filament\Resources\LabTypeResource\Pages;

use App\Filament\Resources\LabTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabType extends EditRecord
{
    protected static string $resource = LabTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
