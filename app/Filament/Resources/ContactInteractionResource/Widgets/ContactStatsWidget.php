<?php

namespace App\Filament\Resources\ContactInteractionResource\Widgets;

use App\Models\ContactInteraction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = ContactInteraction::getStatistics();

        return [
            Stat::make('Checkbox bepipálások', $stats['total_checkbox_checks'])
                ->description('Összesen')
                ->icon('heroicon-o-check-circle')
                ->color('info'),

            Stat::make('Elfogadom kattintások', $stats['total_accept_clicks'])
                ->description('Összesen')
                ->icon('heroicon-o-hand-thumb-up')
                ->color('success'),

            Stat::make('Egyedi sessionök', $stats['unique_sessions'])
                ->description('Különböző felhasználók')
                ->icon('heroicon-o-users')
                ->color('warning'),

            Stat::make('Mai interakciók', $stats['today_interactions'])
                ->description('Ma')
                ->icon('heroicon-o-calendar')
                ->color('primary'),

            Stat::make('Heti interakciók', $stats['this_week_interactions'])
                ->description('Ezen a héten')
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),

            Stat::make('Havi interakciók', $stats['this_month_interactions'])
                ->description('Ebben a hónapban')
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),
        ];
    }
}
