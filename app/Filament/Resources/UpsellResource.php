<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Exports\UpsellExporter;
use App\Filament\Imports\UpsellImporter;
use App\Filament\Resources\UpsellResource\Pages\CreateUpsell;
use App\Filament\Resources\UpsellResource\Pages\EditUpsell;
use App\Filament\Resources\UpsellResource\Pages\ListUpsells;
use App\Models\Project;
use App\Models\Upsell;
use App\Models\UpsellCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class UpsellResource extends Resource
{
    protected static ?string $model = Upsell::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->options(fn () => Project::all()->pluck('company_name', 'id'))
                    ->label('Projekt')
                    ->required(),
                Select::make('upsell_category_id')
                    ->label('Upsell Kategória')
                    ->options(fn () => UpsellCategory::all()->pluck('name', 'id'))
                    ->required(),
                TextInput::make('description')
                    ->label('Leírás')
                    ->maxLength(255),
                TextInput::make('price')
                    ->label('Ár')
                    ->postfix('Ft')
                    ->numeric(),
                Select::make('status')
                    ->options([
                        'Lehetőség' => 'Lehetőség',
                        'Van' => 'Van',
                        'Később' => 'Később',
                        'Nem kell' => 'Nem kell',
                    ])
                    ->label('Státusz')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.company_name')
                    ->label('Projekt')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('project.website_url')
                    ->label('Weboldal URL')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('project.contract_status')
                    ->label('Projekt Státusz')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('upsellCategory.name')
                    ->label('Upsell Kategória')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Leírás')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Ár')
                    ->money('HUF', 0, 'hu_HU')
                    ->summarize([
                        Average::make(),
                        Range::make(),
                    ])
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Státusz'),
                TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Módosítva')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('upsells_status')
                    ->options([
                        'Lehetőség' => 'Lehetőség',
                        'Van' => 'Van',
                        'Később' => 'Később',
                        'Nem kell' => 'Nem kell',
                    ])
                    ->attribute('status')
                    ->label('Upsell Státusz'),
                SelectFilter::make('upsellCategory')
                    ->options(UpsellCategory::all()->pluck('name', 'id'))
                    ->relationship('upsellCategory', 'name')
                    ->attribute('upsellCategory')
                    ->label('Upsell Kategória'),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                ImportAction::make()
                    ->model(self::$model)
                    ->importer(UpsellImporter::class)
                    ->label('Importálás')
                    ->icon('heroicon-o-arrow-down-tray'),
                ExportAction::make()
                    ->model(self::$model)
                    ->exporter(UpsellExporter::class)
                    ->label('Exportálás')
                    ->icon('heroicon-o-arrow-up-tray'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUpsells::route('/'),
            'create' => CreateUpsell::route('/create'),
            'edit' => EditUpsell::route('/{record}/edit'),
        ];
    }
}
