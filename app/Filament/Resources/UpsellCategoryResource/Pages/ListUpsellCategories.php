<?php

namespace App\Filament\Resources\UpsellCategoryResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\UpsellCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUpsellCategories extends ListRecords
{
    protected static string $resource = UpsellCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
