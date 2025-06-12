<?php

namespace App\Filament\Resources\MarketingResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\MarketingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarketings extends ListRecords
{
    protected static string $resource = MarketingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
