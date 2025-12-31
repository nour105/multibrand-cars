<?php

namespace App\Filament\AdminPanel\Widgets;

use App\Models\CtaClick;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CtaStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Call Us Clicks',
                CtaClick::where('cta', 'call_us')->count()
            )
            ->icon('heroicon-o-phone')
            ->color('primary'),

            Stat::make(
                'Request Callback',
                CtaClick::where('cta', 'request_callback')->count()
            )
            ->icon('heroicon-o-chat-bubble-left-right')
            ->color('success'),

            Stat::make(
                'Total Clicks',
                CtaClick::count()
            )
            ->icon('heroicon-o-cursor-arrow-rays')
            ->color('gray'),
        ];
    }
}
