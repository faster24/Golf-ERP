<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Actions\Action;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(20)
                    ->suffixAction(
                        Action::make('generate')
                            ->icon('heroicon-o-sparkles')
                            ->action(function ($set) {
                                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                                $code = '';
                                for ($i = 0; $i < 8; $i++) {
                                    $code .= $characters[rand(0, strlen($characters) - 1)];
                                }
                                $set('code', $code);
                            })
                    ),

                    Forms\Components\TextInput::make('discount_value')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->label('Discount Value (%)')
                        ->suffix('%'),

                    Forms\Components\DatePicker::make('expiration_date')
                        ->required()
                        ->minDate(now())
                        ->native(false)
                        ->displayFormat('M d, Y'),

                    Forms\Components\Toggle::make('is_active')
                        ->default(true)
                        ->inline(false)
                        ->onColor('success')
                        ->offColor('danger')
                        ->label('Active Status')
                        ->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('discount_value')
                    ->formatStateUsing(fn ($state, $record) => $record->discount_type === 'percentage' ? "{$state}%" : "\${$state}"),
                Tables\Columns\TextColumn::make('expiration_date')->date()->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
