<?php

namespace App\Filament\Resources\MarketingResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\MarketingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketing extends EditRecord
{
    protected static string $resource = MarketingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
