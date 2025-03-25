<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Booking;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class LatestBookings extends BaseWidget
{
    protected static ?string $heading = 'Latest Bookings';

    protected int | string | array $columnSpan = 'full'; // Makes the table span the full width

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(Booking::query()->latest()->limit(50)) // Show 5 most recent bookings
            ->columns([
                TextColumn::make('course.course_name')
                    ->label('Course')
                    ->sortable(),
                TextColumn::make('booking_date')
                    ->label('Booking Date'),
                TextColumn::make('booking_time')
                    ->label('Time'),
                TextColumn::make('location_city')
                    ->label('City'),
                TextColumn::make('course.course_name')
                    ->label('Course')
                    ->sortable(),
                TextColumn::make('golfers')
                    ->label('Total Golfers'),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc');
    }
}
