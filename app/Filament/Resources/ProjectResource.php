<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages\CreateProject;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Filament\Resources\ProjectResource\Pages\ListProjects;
use App\Models\Project;
use App\Models\UpsellCategory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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

final class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $modelLabel = 'Projekt';

    protected static ?string $pluralModelLabel = 'Projektek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Alapadatok')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('company_name')->required()->label('Cég neve'),
                            TextInput::make('website_url')->required()->url()->label('Weboldal URL'),
                        ]),
                        Textarea::make('hosting_info')->label('Tárhely infó')->columnSpanFull(),
                        DatePicker::make('last_update_date')->label('Utolsó frissítés'),
                        DatePicker::make('next_update_date')->required()->label('Következő frissítés'),
                        Select::make('update_frequency')->label('Frissítés gyakorisága')
                            ->options([
                                'heti' => 'Heti', 'kétheti' => 'Kétheti', 'havi' => 'Havi', 'negyedéves' => 'Negyedéves', 'igény szerint' => 'Igény szerint',
                            ]),
                        TextInput::make('contract_amount')->numeric()->prefix('Ft')->label('Szerződés összege'),
                        Toggle::make('contract_status')->label('Érvényes szerződés'),
                    ])->columns(2),

                Section::make('Upsell Lehetőségek')
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
                                    ->required()
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
                TextColumn::make('contract_amount')
                    ->label('Szerződés összege')
                    ->numeric()
                    ->summarize([
                        Average::make(),
                        Range::make(),
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
                /* */

                SelectFilter::make('update_frequency')
                    ->options([
                        'heti' => 'Heti',
                        'kétheti' => 'Kétheti',
                        'havi' => 'Havi',
                        'negyedéves' => 'Negyedéves',
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

            ], layout: FiltersLayout::AboveContent)
            ->defaultSort('created_at', 'desc')
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
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
