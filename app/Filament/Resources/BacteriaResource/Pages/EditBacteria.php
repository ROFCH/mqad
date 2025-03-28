<?php

namespace App\Filament\Resources\BacteriaResource\Pages;

use App\Filament\Resources\BacteriaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBacteria extends EditRecord
{
    protected static string $resource = BacteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
