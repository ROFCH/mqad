<?php

namespace App\Filament\Resources\QualabResource\Pages;

use App\Filament\Resources\QualabResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQualab extends EditRecord
{
    protected static string $resource = QualabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
