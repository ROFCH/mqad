<?php

namespace App\Filament\Resources\ReportFormatResource\Pages;

use App\Filament\Resources\ReportFormatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportFormats extends ListRecords
{
    protected static string $resource = ReportFormatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
