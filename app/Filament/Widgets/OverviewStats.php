<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Courses;
use App\Models\Package;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OverviewStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Golf Courses', Courses::count())
                ->description('Number of available courses')
                ->icon('heroicon-o-map')
                ->color('primary'),
            Stat::make('Total Packages', Package::count())
                ->description('Number of available packages')
                ->icon('heroicon-o-briefcase')
                ->color('success'),
            Stat::make('Total Customers', Customer::count())
                ->description('Registered customers')
                ->icon('heroicon-o-users')
                ->color('info'),
        ];
    }
}
