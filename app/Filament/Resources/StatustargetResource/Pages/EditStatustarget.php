<?php

namespace App\Filament\Resources\StatustargetResource\Pages;

use App\Filament\Resources\StatustargetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatustarget extends EditRecord
{
    protected static string $resource = StatustargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
