<?php

namespace App\Filament\AdminPanel\Resources;

use App\Filament\AdminPanel\Resources\MarketingLeadResource\Pages;
use App\Filament\AdminPanel\Resources\MarketingLeadResource\RelationManagers;
use App\Models\MarketingLead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;


class MarketingLeadResource extends Resource
{
    protected static ?string $model = MarketingLead::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('id')->sortable(),

            TextColumn::make('name')
                ->searchable(),

            TextColumn::make('phone')
                ->searchable(),

            TextColumn::make('email')
                ->searchable(),

            TextColumn::make('salary'),

            TextColumn::make('bank'),

            TextColumn::make('source_type'),

            TextColumn::make('car_name'),

            TextColumn::make('offer_title'),

            TextColumn::make('utm_source'),

            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(), // مستحسن
            Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMarketingLeads::route('/'),
            'create' => Pages\CreateMarketingLead::route('/create'),
            'edit' => Pages\EditMarketingLead::route('/{record}/edit'),
        ];
    }    
}
