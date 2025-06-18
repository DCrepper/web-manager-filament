<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Exports\ProjectExporter;
use App\Filament\Imports\ProjectImporter;
use App\Filament\Resources\ProjectResource\Pages\CreateProject;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Filament\Resources\ProjectResource\Pages\ListProjects;
use App\Models\MarketingCategory;
use App\Models\Project;
use App\Models\UpsellCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Number;

final class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $modelLabel = 'Projekt';

    protected static ?string $pluralModelLabel = 'Projektek';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Alapadatok')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('company_name')->required()->label('Cég neve'),
                            TextInput::make('website_url')->required()->url()->label('Weboldal URL'),
                        ]),
                        Select::make('website_type')
                            ->options([
                                'weboldal' => 'Weboldal',
                                'webshop' => 'Webshop',
                            ])
                            ->required()
                            ->label('Weboldal típusa'),
                        TextInput::make('industry')
                            ->label('Iparág'),
                        Select::make('classification')
                            ->options([
                                'U1' => 'U1',
                                'U2' => 'U2',
                                'U3' => 'U3',
                                'U4' => 'U4',
                            ])
                            ->default('U1')
                            ->label('Minősítés'),
                        Textarea::make('hosting_info')->label('Tárhely infó')->columnSpanFull(),
                        DatePicker::make('last_update_date')->label('Utolsó frissítés'),
                        DatePicker::make('next_update_date')->required()->label('Következő frissítés'),
                        Select::make('update_frequency')->label('Frissítés gyakorisága')
                            ->options([
                                'heti' => 'Heti', 'kétheti' => 'Kétheti', 'havi' => 'Havi', 'negyedéves' => 'Negyedéves', 'féléves' => 'Féléves', 'éves' => 'Éves', 'igény szerint' => 'Igény szerint',
                            ]),
                        TextInput::make('contract_amount')->numeric()->prefix('Ft')->label('Szerződés összege'),
                        RichEditor::make('notes')
                            ->label('Megjegyzések')
                            ->limit(500),
                        Toggle::make('contract_status')->label('Érvényes szerződés'),
                        Select::make('status')
                            ->options([
                                'active' => 'Aktív',
                                'inactive' => 'Inaktív',
                            ])
                            ->default('active')
                            ->required()
                            ->label('Státusz'),
                    ])->columns(2),

                Section::make('Upsell Lehetőségek')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('upsells')
                            ->relationship('upsells')
                            ->schema([
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
                                    ->default('Lehetőség')
                                    ->required(),
                            ])
                            ->columns(4)
                            ->addActionLabel('Új Upsell hozzáadása')
                            ->label('Upsell Lehetőségek'),
                    ]),

                Section::make('Marketing')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('marketing')
                            ->relationship('marketing')
                            ->schema([
                                Select::make('marketing_category_id')
                                    ->label('Marketing Kategória')
                                    ->options(fn () => MarketingCategory::all()->pluck('name', 'id'))
                                    ->required(),
                                TextInput::make('monthly_management_fee')
                                    ->label('Havi kezelési díj')
                                    ->numeric()
                                    ->postfix('Ft'),
                                TextInput::make('advertising_cost')
                                    ->label('Hirdetési költség')
                                    ->numeric()
                                    ->postfix('Ft'),
                                Select::make('advertising_payer')
                                    ->label('Hirdetés fizető')
                                    ->options([
                                        'client' => 'Ügyfél',
                                        'cegem360' => 'Cegem360',
                                    ]),
                                TextInput::make('post_frequency')
                                    ->label('Poszt gyakoriság')
                                    ->maxLength(255),
                                Textarea::make('notes')
                                    ->label('Megjegyzések')
                                    ->maxLength(1000),
                                DatePicker::make('order_date')
                                    ->label('Megrendelés dátuma'),
                                Select::make('status')
                                    ->label('Státusz')
                                    ->options([
                                        'active' => 'Aktív',
                                        'closed' => 'Lezárt',
                                    ])
                                    ->default('active')
                                    ->required(),
                            ])
                            ->columns(3)
                            ->addActionLabel('Új Marketing szolgáltatás hozzáadása')
                            ->label('Marketing szolgáltatások'),
                    ]),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')
                    ->label('Cég neve')
                    ->searchable(),
                TextColumn::make('website_url')
                    ->label('Weboldal URL')
                    ->searchable(),
                TextColumn::make('industry')
                    ->label('Iparág')
                    ->searchable(),
                TextColumn::make('website_type')
                    ->label('Weboldal típusa')
                    ->sortable(),
                TextColumn::make('classification')
                    ->label('Minősítés')
                    ->sortable(),
                TextColumn::make('last_update_date')
                    ->label('Utolsó frissítés')
                    ->date()
                    ->sortable(),
                TextColumn::make('next_update_date')
                    ->label('Következő frissítés')
                    ->date()
                    ->sortable(),
                TextColumn::make('update_frequency')
                    ->label('Frissítés gyakorisága'),
                IconColumn::make('contract_status')
                    ->label('Szerződés státusz')
                    ->boolean(),
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Aktív',
                        'inactive' => 'Inaktív',
                    }),
                TextColumn::make('contract_amount')
                    ->label('Szerződés összege')
                    ->formatStateUsing(fn ($state) => Number::currency($state, 'HUF', 'hu_HU', 0))
                    ->summarize([
                        Average::make(),
                        Range::make(),
                        Sum::make(),
                    ])
                    ->sortable(),
                TextColumn::make('currency')
                    ->label('Valuta')
                    ->searchable(),
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

                SelectFilter::make('update_frequency')
                    ->options([
                        'heti' => 'Heti',
                        'kétheti' => 'Kétheti',
                        'havi' => 'Havi',
                        'negyedéves' => 'Negyedéves',
                        'féléves' => 'Féléves',
                        'éves' => 'Éves',
                        'igény szerint' => 'Igény szerint',
                    ])
                    ->label('Frissítés gyakorisága'),
                SelectFilter::make('contract_status')
                    ->options([
                        true => 'Érvényes szerződés',
                        false => 'Nincs érvényes szerződés',
                    ])
                    ->label('Szerződés státusz'),
                SelectFilter::make('last_update_date')
                    ->options([
                        'today' => 'Ma',
                        'this_week' => 'Ezen a héten',
                        'this_month' => 'Ebben a hónapban',
                        'last_month' => 'Múlt hónapban',
                    ])
                    ->query(function ($query, $state) {
                        return match ($state['value'] ?? null) {
                            'today' => $query->whereDate('last_update_date', today()),
                            'this_week' => $query->whereBetween('last_update_date', [now()->startOfWeek(), now()->endOfWeek()]),
                            'this_month' => $query->whereBetween('last_update_date', [now()->startOfMonth(), now()->endOfMonth()]),
                            'last_month' => $query->whereBetween('last_update_date', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]),
                            default => $query,
                        };
                    })
                    ->label('Utolsó frissítés'),
                SelectFilter::make('next_update_date')
                    ->options([
                        'today' => 'Ma',
                        'this_week' => 'Ezen a héten',
                        'this_month' => 'Ebben a hónapban',
                        'overdue' => 'Lejárt',
                    ])
                    ->query(function ($query, $state) {
                        return match ($state['value'] ?? null) {
                            'today' => $query->whereDate('next_update_date', today()),
                            'this_week' => $query->whereBetween('next_update_date', [now()->startOfWeek(), now()->endOfWeek()]),
                            'this_month' => $query->whereBetween('next_update_date', [now()->startOfMonth(), now()->endOfMonth()]),
                            'overdue' => $query->where('next_update_date', '<', today()),
                            default => $query,
                        };
                    })
                    ->label('Következő frissítés'),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktív',
                        'inactive' => 'Inaktív',
                    ])
                    ->label('Státusz'),

            ], layout: FiltersLayout::AboveContent)
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ImportAction::make()
                    ->label('Projekt importálása')

                    ->importer(ProjectImporter::class)
                    ->successNotificationTitle('Sikeres importálás'),

                ExportAction::make()
                    ->label('Projekt exportálása')

                    ->exporter(ProjectExporter::class)
                    ->successNotificationTitle('Sikeres exportálás'),

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
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
