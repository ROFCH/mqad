<?php

namespace App\Filament\Resources\ZsrglnResource\Pages;

use App\Filament\Resources\ZsrglnResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditZsrgln extends EditRecord
{
    protected static string $resource = ZsrglnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
