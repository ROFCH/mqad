<?php

namespace App\Filament\Resources\ZsrglnResource\Pages;

use App\Filament\Resources\ZsrglnResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListZsrglns extends ListRecords
{
    protected static string $resource = ZsrglnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
