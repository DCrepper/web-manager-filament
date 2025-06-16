<?php

declare(strict_types=1);

namespace App\Filament\Imports;

use App\Models\Project;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

final class ProjectImporter extends Importer
{
    protected static ?string $model = Project::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('company_name')
                ->rules(['max:255']),
            ImportColumn::make('website_url')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('hosting_info'),
            ImportColumn::make('website_type')
                ->rules(['in:weboldal,webshop']),
            ImportColumn::make('industry')
                ->rules(['max:255']),
            ImportColumn::make('classification'),
            ImportColumn::make('last_update_date')
                ->rules(['date']),
            ImportColumn::make('next_update_date')
                ->rules(['date']),
            ImportColumn::make('update_frequency'),
            ImportColumn::make('contract_status')
                ->boolean(),
            ImportColumn::make('contract_amount')
                ->numeric(),
            ImportColumn::make('currency'),
            ImportColumn::make('notes'),
            ImportColumn::make('upsells'),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your project import has completed and '.Number::format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }

    public function resolveRecord(): Project
    {
        return Project::firstOrNew([
            'website_url' => $this->data['website_url'],
        ]);
    }
}
