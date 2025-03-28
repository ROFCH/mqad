<?php

namespace App\Filament\Resources\StatmethodResource\Pages;

use App\Filament\Resources\StatmethodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatmethod extends EditRecord
{
    protected static string $resource = StatmethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
