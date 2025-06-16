<?php

namespace App\Filament\Exports;

use App\Models\Project;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ProjectExporter extends Exporter
{
    protected static ?string $model = Project::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('company_name'),
            ExportColumn::make('website_url'),
            ExportColumn::make('hosting_info'),
            ExportColumn::make('website_type'),
            ExportColumn::make('industry'),
            ExportColumn::make('classification'),
            ExportColumn::make('last_update_date'),
            ExportColumn::make('next_update_date'),
            ExportColumn::make('update_frequency'),
            ExportColumn::make('contract_status'),
            ExportColumn::make('contract_amount'),
            ExportColumn::make('currency'),
            ExportColumn::make('notes'),
            ExportColumn::make('upsells'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your project export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
