<?php

declare(strict_types=1);

namespace App\Filament\Imports;

use App\Models\Project;
use App\Models\Upsell;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

final class UpsellImporter extends Importer
{
    protected static ?string $model = Upsell::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('project')
                ->requiredMapping()
                ->relationship(resolveUsing: 'website_url')
                ->rules(['required']),
            ImportColumn::make('upsellCategory')
                ->requiredMapping()
                ->relationship(resolveUsing: 'name')
                ->rules(['required']),
            ImportColumn::make('description')
                ->rules(['max:255']),
            ImportColumn::make('price'),
            ImportColumn::make('status')
                ->requiredMapping()
                ->rules(['required']),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your upsell import has completed and '.Number::format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }

    public function resolveRecord(): Upsell
    {
        $project = Project::where('website_url', $this->data['project'])
            ->firstOrFail();

        return Upsell::firstOrNew([
            'project_id' => $project->id,
        ]);
    }
}
