<?php

namespace App\Filament\AdminPanel\Resources;

use App\Filament\AdminPanel\Resources\MarketingLeadResource\Pages;
use App\Models\MarketingLead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class MarketingLeadResource extends Resource
{
    protected static ?string $model = MarketingLead::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // يمكنك إضافة الفورم هنا لاحقاً إذا لزم
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('salary'),
                TextColumn::make('bank'),
                TextColumn::make('source_type'),
                TextColumn::make('car_name'),
                TextColumn::make('offer_title'),
                TextColumn::make('utm_source'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                // فلتر حسب التاريخ
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('From Date'),
                        Forms\Components\DatePicker::make('until')->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'] ?? null, fn($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'] ?? null, fn($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export Excel')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(function () {
                                return 'marketing-leads-' . now()->format('Y-m-d_H-i');
                            }),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMarketingLeads::route('/'),
            'create' => Pages\CreateMarketingLead::route('/create'),
            'edit' => Pages\EditMarketingLead::route('/{record}/edit'),
        ];
    }
}
