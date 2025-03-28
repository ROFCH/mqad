<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\Exporter;
use Illuminate\Database\Query\Builder;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class test extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('code'),    
            ExportColumn::make('textde'),
            ExportColumn::make('sample'),
      
            ExportColumn::make('price'),
           
            // ExportColumn::make('subscriptions_count')
            //     ->counts('subscriptions')
            //     ->state(function (Product $record): float {
            //             return $record->subscriptions_count * $record.price;
            //     }),
        



            // ExportColumn::make('subscriptions_count')->counts([
            //  'subscriptions' => fn (Builder $query) => $query->where('free','=','1' ),
            // ])



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
