<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

final class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $vanStatusCount = Project::all()->pluck('upsells')->flatten()->where('status', 'Van')->count();

        return [
            Stat::make('Aktív Projektek', Project::where('contract_status', true)->count())
                ->description('Érvényes szerződéssel')
                ->color('success'),
            Stat::make('Lejárt Határidők', Project::where('next_update_date', '<', now())->count())
                ->description('Azonnali figyelmet igényel')
                ->color('danger'),
            Stat::make('Eladott Upsell-ek', $vanStatusCount)
                ->description("'Van' státuszú szolgáltatások")
                ->color('info'),
        ];
    }
}
