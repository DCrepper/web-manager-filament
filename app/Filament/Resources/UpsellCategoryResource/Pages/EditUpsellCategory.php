<?php

namespace App\Filament\Resources\UpsellCategoryResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\UpsellCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUpsellCategory extends EditRecord
{
    protected static string $resource = UpsellCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
