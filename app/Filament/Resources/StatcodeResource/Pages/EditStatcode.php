<?php

namespace App\Filament\Resources\StatcodeResource\Pages;

use App\Filament\Resources\StatcodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatcode extends EditRecord
{
    protected static string $resource = StatcodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
