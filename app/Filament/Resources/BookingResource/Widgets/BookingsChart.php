<?php

namespace App\Filament\Resources\BookingResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Booking;
use Illuminate\Support\Carbon;

class BookingsChart extends ChartWidget
{
    protected static ?string $heading = 'Reservation Analytics';

    protected function getData(): array
    {
        $bookings = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $bookings->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d'));
        $data = $bookings->pluck('count');

        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => $data,
                    'borderColor' => '#4CAF50',
                    'backgroundColor' => 'rgba(76, 175, 80, 0.2)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
