<?php

namespace App\Filament\Exports;

use App\Models\Target;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TargetExporter extends Exporter
{
    protected static ?string $model = Target::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('method.id'),
            ExportColumn::make('method_num'),
            ExportColumn::make('substancede'),
            ExportColumn::make('instrumentde'),
            ExportColumn::make('value'),
            ExportColumn::make('deviation'),
            ExportColumn::make('total'),
            ExportColumn::make('count1'),
            ExportColumn::make('count2'),
            ExportColumn::make('count3'),
            ExportColumn::make('count4'),
            ExportColumn::make('mean'),
            ExportColumn::make('sum'),
            ExportColumn::make('l1'),
            ExportColumn::make('l2'),
            ExportColumn::make('l3'),
            ExportColumn::make('lg'),
            ExportColumn::make('lt1'),
            ExportColumn::make('lt2'),
            ExportColumn::make('lt3'),
            ExportColumn::make('stat'),
            ExportColumn::make('sq1'),
            ExportColumn::make('sq2'),
            ExportColumn::make('sq3'),
            ExportColumn::make('sq4'),
            ExportColumn::make('sq5'),
            ExportColumn::make('sq6'),
            ExportColumn::make('sq7'),
            ExportColumn::make('sq8'),
            ExportColumn::make('sq9'),
            ExportColumn::make('autp'),
            ExportColumn::make('beme'),
            ExportColumn::make('code'),
            ExportColumn::make('fmit'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('year'),
            ExportColumn::make('quarter'),
            ExportColumn::make('points'),
            ExportColumn::make('survey.id'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your target export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
