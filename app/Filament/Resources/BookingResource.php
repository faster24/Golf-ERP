<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Booking Date')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('booking_time')
                    ->label('Booking Time')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('location_city')
                    ->label('City')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('location_country')
                    ->label('Country')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('course.course_name')
                    ->label('Course')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('golfers')
                    ->label('Golfers')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('holes')
                    ->label('Holes')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('package.name')
                    ->label('Package')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('hole_price')
                    ->label('Hole Price')
                    ->money('THB') // Format as Thai Baht
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Price')
                    ->money('THB') // Format as Thai Baht
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Add filters if needed
                Tables\Filters\Filter::make('booking_date')
                    ->form([
                        Forms\Components\DatePicker::make('booking_date')
                            ->label('Filter by Booking Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['booking_date'])) {
                            return $query->whereDate('booking_date', $data['booking_date']);
                        }
                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

}
