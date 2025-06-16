<?php

namespace App\Filament\Exports;

use App\Models\Marketing;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class MarketingExporter extends Exporter
{
    protected static ?string $model = Marketing::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('project.id'),
            ExportColumn::make('marketingCategory.name'),
            ExportColumn::make('monthly_management_fee'),
            ExportColumn::make('advertising_cost'),
            ExportColumn::make('advertising_payer'),
            ExportColumn::make('post_frequency'),
            ExportColumn::make('notes'),
            ExportColumn::make('order_date'),
            ExportColumn::make('status'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your marketing export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
