<?php

namespace App\Filament\AdminPanel\Resources\MarketingLeadResource\Pages;

use App\Filament\AdminPanel\Resources\MarketingLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarketingLeads extends ListRecords
{
    protected static string $resource = MarketingLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
