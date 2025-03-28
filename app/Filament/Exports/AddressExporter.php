<?php

namespace App\Filament\Exports;

use App\Models\Address;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AddressExporter extends Exporter
{
    protected static ?string $model = Address::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('salutation'),
            ExportColumn::make('name'),
            ExportColumn::make('address'),
            ExportColumn::make('address2'),
            ExportColumn::make('postal_code'),
            ExportColumn::make('city'),
            ExportColumn::make('country'),
            ExportColumn::make('phone'),
            ExportColumn::make('mail'),
            ExportColumn::make('contact'),
            ExportColumn::make('remarks'),
            ExportColumn::make('language.id'),
            ExportColumn::make('labType.id'),
            ExportColumn::make('labGroup.id'),
            ExportColumn::make('qualab'),
            ExportColumn::make('no_charge'),
            ExportColumn::make('status.id'),
            ExportColumn::make('report_size_id'),
            ExportColumn::make('invoice_name'),
            ExportColumn::make('invoice_address'),
            ExportColumn::make('invoice_address2'),
            ExportColumn::make('invoice_address3'),
            ExportColumn::make('invoice_street'),
            ExportColumn::make('invoice_postal_code'),
            ExportColumn::make('invoice_city'),
            ExportColumn::make('invoice_country'),
            ExportColumn::make('invoice_mail'),
            ExportColumn::make('invoiceType.id'),
            ExportColumn::make('no_membership'),
            ExportColumn::make('simple_membership'),
            ExportColumn::make('shipFormat.id'),
            ExportColumn::make('reportType.id'),
            ExportColumn::make('h3_education_only'),
            ExportColumn::make('difficult'),
            ExportColumn::make('online_num'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('shipType.id'),
            ExportColumn::make('reportFormat.id'),
            ExportColumn::make('no_reminder'),
            ExportColumn::make('temp_no_reminder'),
            ExportColumn::make('created_at'),
            ExportColumn::make('qualab_num'),
            ExportColumn::make('sas_num'),
            ExportColumn::make('swissmedic_num'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your address export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
