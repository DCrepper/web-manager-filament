<?php

namespace App\Filament\Resources\MarketingCategoryResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\MarketingCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketingCategory extends EditRecord
{
    protected static string $resource = MarketingCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
