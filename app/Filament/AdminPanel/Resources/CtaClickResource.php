<?php

namespace App\Filament\AdminPanel\Resources;

use App\Filament\AdminPanel\Resources\CtaClickResource\Pages;
use App\Models\CtaClick;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CtaClickResource extends Resource
{
    protected static ?string $model = CtaClick::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-rays';

    protected static ?string $navigationLabel = 'CTA Analytics';

    protected static ?string $navigationGroup = 'Analytics';

    /**
     * ❌ Disable create completely
     */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cta')
                    ->label('CTA Type')
                    ->badge()
                    ->colors([
                        'primary' => 'call_us',
                        'success' => 'request_callback',
                    ]),

                Tables\Columns\TextColumn::make('car_name')
                    ->label('Car')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Clicked At')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Date filters later if needed
            ])
            ->actions([]) // ❌ No row actions
            ->bulkActions([]); // ❌ No bulk actions
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCtaClicks::route('/'),
        ];
    }
}
