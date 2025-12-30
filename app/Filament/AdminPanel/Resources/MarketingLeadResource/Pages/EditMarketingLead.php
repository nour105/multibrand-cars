<?php

namespace App\Filament\AdminPanel\Resources\MarketingLeadResource\Pages;

use App\Filament\AdminPanel\Resources\MarketingLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketingLead extends EditRecord
{
    protected static string $resource = MarketingLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
