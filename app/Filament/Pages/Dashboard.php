<?php

namespace App\Filament\Pages;

use App\Filament\Resources\BookingResource\Widgets\BookingStats;
use Filament\Pages\Page;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            BookingStats::class,
        ];
    }
}
