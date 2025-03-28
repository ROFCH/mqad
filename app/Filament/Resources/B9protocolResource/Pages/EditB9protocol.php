<?php

namespace App\Filament\Resources\B9protocolResource\Pages;

use App\Filament\Resources\B9protocolResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditB9protocol extends EditRecord
{
    protected static string $resource = B9protocolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
