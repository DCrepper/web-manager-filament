<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UpsellResource\Pages\CreateUpsell;
use App\Filament\Resources\UpsellResource\Pages\EditUpsell;
use App\Filament\Resources\UpsellResource\Pages\ListUpsells;
use App\Models\Project;
use App\Models\Upsell;
use App\Models\UpsellCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    ->required()
                    ->label('Ár')
                    ->postfix('Ft')
                    ->numeric(),
                TextInput::make('status')
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
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
