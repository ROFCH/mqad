<?php

namespace App\Filament\Exports;

use App\Models\Protocol;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProtocolExporter extends Exporter
{
    protected static ?string $model = Protocol::class;

    public static function getColumns(): array
    {
        return [
            // ExportColumn::make('id')
            //     ->label('ID'),
            ExportColumn::make('address_id'),
            ExportColumn::make('address.name'),
            ExportColumn::make('method.id'),
            ExportColumn::make('method.substancede'),
            ExportColumn::make('method.instrumentde'),
            ExportColumn::make('unit.textde'),
            ExportColumn::make('device.id'),
            ExportColumn::make('device.textde'),
            ExportColumn::make('device_num'),
            ExportColumn::make('Serialnumber'),
            ExportColumn::make('department'),
            // ExportColumn::make('start_date'),
            ExportColumn::make('start_year'),
            ExportColumn::make('start_quarter'),
            // ExportColumn::make('stop_date'),
            ExportColumn::make('stop_year'),
            ExportColumn::make('stop_quarter'),
            // ExportColumn::make('updated_at'),
            // ExportColumn::make('created_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your protocol export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
