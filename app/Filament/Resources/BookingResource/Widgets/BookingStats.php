<?php

namespace App\Filament\Resources\BookingResource\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalBookings = Booking::count();

        $totalRevenue = Booking::sum('total_price');

        $averageRevenue = $totalBookings > 0 ? $totalRevenue / $totalBookings : 0;

        return [
            Stat::make('Total Bookings', $totalBookings)
                ->description('All bookings in the system')
                ->color('primary'),

            Stat::make('Total Revenue', number_format($totalRevenue, 2) . ' THB')
                ->description('Total revenue from all bookings')
                ->color('success'),

            Stat::make('Average Revenue per Booking', number_format($averageRevenue, 2) . ' THB')
                ->description('Average revenue per booking')
                ->color('info'),
        ];

    }
}
