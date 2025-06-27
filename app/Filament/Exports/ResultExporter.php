<?php

namespace App\Filament\Exports;

use App\Models\Result;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ResultExporter extends Exporter
{
    protected static ?string $model = Result::class;

    public static function getColumns(): array
    {
        return [
            //
            ExportColumn::make('method.substance.product.code'),
            ExportColumn::make('method.substance.textde'),
            ExportColumn::make('method.instrument.textde'),
            ExportColumn::make('method.number'),
            ExportColumn::make('address.id'),
            ExportColumn::make('address.name'),
            ExportColumn::make('value'),
            ExportColumn::make('unit.unitsymbol.textde'),
            ExportColumn::make('additional_value'),
            ExportColumn::make('device_num'),
            ExportColumn::make('device.textde'),
            ExportColumn::make('serialnumber'),
            ExportColumn::make('department'),
            ExportColumn::make('staff_id'),
            ExportColumn::make('survey_id'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your result export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
