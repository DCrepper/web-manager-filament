<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages\CreateProject;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Filament\Resources\ProjectResource\Pages\ListProjects;
use App\Models\Project;
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
use Filament\Tables\Columns\TextColumn;
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
                        Repeater::make('upsell_categories')
                            ->label('Upsell Lehetőségek')
                            ->schema([
                                TextInput::make('name')->required()->label('Név'),
                                Select::make('status')
                                    ->options([
                                        'Lehetőség' => 'Lehetőség', 'Van' => 'Van', 'Később' => 'Később', 'Nem kell' => 'Nem kell',
                                    ])->required()->default('Lehetőség'),
                                Textarea::make('notes')->label('Megjegyzés')->columnSpanFull(),

                            ])
                            ->columns(2)
                            ->label(''),
                    ]),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')
                    ->searchable(),
                TextColumn::make('website_url')
                    ->searchable(),
                TextColumn::make('last_update_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('next_update_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('update_frequency'),
                IconColumn::make('contract_status')
                    ->boolean(),
                TextColumn::make('contract_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('currency')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
