<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('textde'),
            ExportColumn::make('sample'),
            ExportColumn::make('code'),
            ExportColumn::make('price'),
            ExportColumn::make('sort'),
            ExportColumn::make('delivery_note'),
            ExportColumn::make('packaging'),
            ExportColumn::make('membership'),
            ExportColumn::make('type'),
            ExportColumn::make('sort2'),
            ExportColumn::make('evaluation'),
            ExportColumn::make('sort3'),
            ExportColumn::make('size'),
            ExportColumn::make('weight'),
            ExportColumn::make('translation.id'),
            ExportColumn::make('matrix'),
            ExportColumn::make('infectious'),
            ExportColumn::make('active'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('volume'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your product export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
