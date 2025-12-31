<?php

namespace App\Filament\AdminPanel\Resources\CtaClickResource\Pages;

use App\Filament\AdminPanel\Resources\CtaClickResource;
use App\Filament\AdminPanel\Widgets\CtaStats;
use Filament\Resources\Pages\ListRecords;

class ListCtaClicks extends ListRecords
{
    protected static string $resource = CtaClickResource::class;

    protected function getHeaderActions(): array
    {
        return []; // ❌ no Create button
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CtaStats::class, // ✅ charts / counters فوق الجدول
        ];
    }
}
