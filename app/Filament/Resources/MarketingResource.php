<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Exports\MarketingExporter;
use App\Filament\Resources\MarketingResource\Pages\CreateMarketing;
use App\Filament\Resources\MarketingResource\Pages\EditMarketing;
use App\Filament\Resources\MarketingResource\Pages\ListMarketings;
use App\Models\Marketing;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Models\Export;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Number;

final class MarketingResource extends Resource
{
    protected static ?string $model = Marketing::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'company_name')
                    ->required(),
                Select::make('marketing_category_id')
                    ->relationship('marketingCategory', 'name')
                    ->required(),
                TextInput::make('monthly_management_fee')
                    ->numeric(),
                TextInput::make('advertising_cost')
                    ->numeric(),
                Select::make('advertising_payer')
                    ->options([
                        'client' => 'Client',
                        'cegem360' => 'Cegem360',
                    ]),
                TextInput::make('post_frequency')
                    ->maxLength(255),
                Textarea::make('notes')
                    ->columnSpanFull(),
                DatePicker::make('order_date'),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'closed' => 'Closed',
                    ])
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
                TextColumn::make('marketingCategory.name')
                    ->label('Marketing kategória')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('monthly_management_fee')
                    ->formatStateUsing(fn ($state) => Number::currency($state, 'HUF', 'hu_HU', 0))
                    ->label('Havi menedzsment díj')
                    ->summarize([
                        Average::make(),
                        Range::make(),
                    ])
                    ->sortable(),
                TextColumn::make('advertising_cost')
                    ->label('Hirdetési költés')
                    ->formatStateUsing(fn ($state) => Number::currency($state, 'HUF', 'hu_HU', 0))
                    ->summarize([
                        Average::make(),
                        Range::make(),
                    ])
                    ->label('Hirdetési költség')
                    ->sortable(),
                TextColumn::make('advertising_payer')
                    ->label('Hirdetés fizető')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'client' => 'primary',
                        'cegem360' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('post_frequency')
                    ->label('Poszt gyakoriság')
                    ->searchable(),
                TextColumn::make('order_date')
                    ->label('Megrendelés dátuma')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'closed' => 'danger',
                    }),
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
                SelectFilter::make('status')
                    ->label('Állapot')
                    ->options([
                        'active' => 'Aktív',
                        'closed' => 'Inaktív',
                    ]),
                SelectFilter::make('marketing_category_id')
                    ->label('Kategória')
                    ->relationship('marketingCategory', 'name'),
                SelectFilter::make('advertising_payer')
                    ->label('Ki a kifizető')
                    ->options([
                        'client' => 'Client',
                        'cegem360' => 'Cegem360',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Marketing exportálása')
                    ->icon('heroicon-o-download')
                    ->exporter(MarketingExporter::class)
                    ->successNotificationTitle('Sikeres exportálás')
                    ->successNotificationBody(fn (Export $export) => MarketingExporter::getCompletedNotificationBody($export)),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => ListMarketings::route('/'),
            'create' => CreateMarketing::route('/create'),
            'edit' => EditMarketing::route('/{record}/edit'),
        ];
    }
}
