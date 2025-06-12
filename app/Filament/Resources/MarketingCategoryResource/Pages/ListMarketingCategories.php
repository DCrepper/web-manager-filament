<?php

namespace App\Filament\Resources\MarketingCategoryResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\MarketingCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarketingCategories extends ListRecords
{
    protected static string $resource = MarketingCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
