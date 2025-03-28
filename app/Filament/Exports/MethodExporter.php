<?php

namespace App\Filament\Exports;

use App\Models\Method;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class MethodExporter extends Exporter
{
    protected static ?string $model = Method::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('number'),
            ExportColumn::make('substance.id'),
            ExportColumn::make('instrument.id'),
            ExportColumn::make('substancede'),
            ExportColumn::make('instrumentde'),
            ExportColumn::make('sort'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('created_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your method export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
