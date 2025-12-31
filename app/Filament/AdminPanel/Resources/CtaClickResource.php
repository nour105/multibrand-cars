<?php

namespace App\Filament\AdminPanel\Resources;

use App\Filament\AdminPanel\Resources\CtaClickResource\Pages;
use App\Models\CtaClick;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Illuminate\Database\Eloquent\Builder;

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
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('From Date'),
                        DatePicker::make('until')->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn (Builder $query, $date) => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn (Builder $query, $date) => $query->whereDate('created_at', '<=', $date)
                            );
                    }),
            ])
            ->actions([])
            ->headerActions([
                ExportAction::make()
                    ->label('Export Excel')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(function () {
                                return 'cta-clicks-' . now()->format('Y-m-d_H-i');
                            }),
                    ]),
            ])
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
