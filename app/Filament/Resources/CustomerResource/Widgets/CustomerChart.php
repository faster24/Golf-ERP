<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Customer;
use Filament\Widgets\ChartWidget;
use App\Models\Customers;
use Illuminate\Support\Carbon;

class CustomerChart extends ChartWidget
{
    protected static ?string $heading = 'Customer Trends';

    public ?string $filter = 'month'; // Default filter: monthly

    protected function getFilters(): ?array
    {
        return [
            'month' => 'By Month (Last 12 Months)',
            'year' => 'By Year (Last 5 Years)',
        ];
    }

    protected function getData(): array
    {
        $query = Customer::query();

        if ($this->filter === 'month') {
            // Last 12 months
            $startDate = Carbon::now()->subMonths(11)->startOfMonth();
            $format = 'M Y'; // e.g., "Mar 2025"
            $groupBy = "DATE_FORMAT(created_at, '%Y-%m')";
        } else {
            // Last 5 years
            $startDate = Carbon::now()->subYears(4)->startOfYear();
            $format = 'Y'; // e.g., "2025"
            $groupBy = "YEAR(created_at)";
        }

        $customerData = $query
            ->selectRaw("$groupBy as period, COUNT(*) as new_customers")
            ->where('created_at', '>=', $startDate)
            ->groupByRaw($groupBy)
            ->orderBy('period', 'asc')
            ->get();

        $labels = $customerData->pluck('period')->map(fn($period) => Carbon::parse($period)->format($format));
        $data = $customerData->pluck('new_customers');

        return [
            'datasets' => [
                [
                    'label' => 'New Registered Users',
                    'data' => $data,
                    'borderColor' => '#2196F3',
                    'backgroundColor' => 'rgba(33, 150, 243, 0.2)',
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
