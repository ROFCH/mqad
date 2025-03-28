<?php

namespace App\Filament\Resources\SterilizerResource\Pages;

use App\Filament\Resources\SterilizerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSterilizer extends EditRecord
{
    protected static string $resource = SterilizerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
