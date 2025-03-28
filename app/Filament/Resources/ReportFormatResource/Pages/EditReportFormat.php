<?php

namespace App\Filament\Resources\ReportFormatResource\Pages;

use App\Filament\Resources\ReportFormatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportFormat extends EditRecord
{
    protected static string $resource = ReportFormatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
