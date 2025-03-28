<?php

namespace App\Filament\Exports;

use App\Models\Substance;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SubstanceExporter extends Exporter
{
    protected static ?string $model = Substance::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('textde'),
            ExportColumn::make('translation.id'),
            ExportColumn::make('unitsi'),
            ExportColumn::make('unitold'),
            ExportColumn::make('conversion'),
            ExportColumn::make('decimalsi'),
            ExportColumn::make('decimalold'),
            ExportColumn::make('tolerance'),
            ExportColumn::make('type'),
            ExportColumn::make('sort'),
            ExportColumn::make('qualab_id'),
            ExportColumn::make('evaluation_id'),
            ExportColumn::make('limit1'),
            ExportColumn::make('limit2'),
            ExportColumn::make('toleranceabs'),
            ExportColumn::make('ealn'),
            ExportColumn::make('ealn_subcode'),
            ExportColumn::make('publish'),
            ExportColumn::make('remark'),
            ExportColumn::make('product.id'),
            ExportColumn::make('zero'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('created_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your substance export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
