<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        FileUpload::configureUsing(fn (FileUpload $fileUpload): FileUpload => $fileUpload
            ->visibility('public'));

        ImageColumn::configureUsing(fn (ImageColumn $imageColumn): ImageColumn => $imageColumn
            ->visibility('public'));

        ImageEntry::configureUsing(fn (ImageEntry $imageEntry): ImageEntry => $imageEntry
            ->visibility('public'));

        Fieldset::configureUsing(fn (Fieldset $fieldset) => $fieldset
            ->columnSpanFull());

        Grid::configureUsing(fn (Grid $grid) => $grid
            ->columnSpanFull());

        Section::configureUsing(fn (Section $section) => $section
            ->columnSpanFull());
    }
}
