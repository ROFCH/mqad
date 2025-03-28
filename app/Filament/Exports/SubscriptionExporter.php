<?php

namespace App\Filament\Exports;

use App\Models\Subscription;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SubscriptionExporter extends Exporter
{
    protected static ?string $model = Subscription::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id'),
            ExportColumn::make('address_id')
                ->label('Tnr'),
            ExportColumn::make('address.name')
                ->label('Teilnehmername'),
            ExportColumn::make('product.code')
                ->label('Probe'),
            ExportColumn::make('sample_quantity')
                ->label('Anzahl'),
            ExportColumn::make('start_year')
                ->label('Beginn Jahr'),
            ExportColumn::make('start_quarter')
                ->label('Beginn Quartal'),
            ExportColumn::make('stop_year')
                ->label('End Jahr'),
            ExportColumn::make('stop_quarter')
                ->label('End Quartal'),
            ExportColumn::make('free')
                ->label('gratis'),           

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your subscription export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
