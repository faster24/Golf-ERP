<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Actions\BulkAction;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Http;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('phone')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined at')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('sendCertificate')
                    ->label('Send Certificate')
                    ->icon('heroicon-o-document-text')
                    ->form([
                        TextInput::make('playerName')
                            ->label('Player Name')
                            ->default(fn ($record) => $record->name) // Pre-fill with user's name
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->default(fn ($record) => $record->email) // Pre-fill with user's email
                            ->email()
                            ->required(),
                        TextInput::make('position')
                            ->label('Position')
                            ->placeholder('e.g., 1st Place, 2nd Place')
                            ->required(),
                        TextInput::make('score')
                            ->label('Score')
                            ->numeric()
                            ->required(),
                        TextInput::make('tournamentName')
                            ->label('Tournament Name')
                            ->default('Legends Golf Championship')
                            ->required(),
                        DatePicker::make('date')
                            ->label('Date')
                            ->default('2025-03-15')
                            ->required(),
                        TextInput::make('location')
                            ->label('Location')
                            ->default('Bangkok')
                            ->required(),
                    ])
                    ->action(function (Customer $record, array $data) {
                        // Prepare the payload for this specific user
                        $payload = [
                            'playerName' => $data['playerName'],
                            'email' => $data['email'],
                            'position' => $data['position'],
                            'score' => $data['score'],
                            'tournamentName' => $data['tournamentName'],
                            'date' => $data['date'],
                            'location' => $data['location'],
                        ];

                        try {
                            // Send the POST request to the API
                            $response = Http::post('https://cimso-golf-booking-demo.onrender.com/v1/api/emails/send-email-certificate', $payload);

                            if ($response->successful()) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Certificate Sent')
                                    ->body("Certificate sent to {$payload['email']} for {$payload['position']}.")
                                    ->success()
                                    ->send();
                            } else {
                                throw new \Exception('API request failed: ' . $response->body());
                            }
                        } catch (\Exception $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Error')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                BulkAction::make('assignCoupon')
                    ->label('Assign Existing Coupon')
                    ->icon('heroicon-o-ticket')
                    ->form([
                        Select::make('coupon_id')
                            ->label('Select Coupon')
                            ->options(Coupon::pluck('code', 'id')->toArray()) // Lists all coupons by their code
                            ->searchable() // Optional: Makes it easier to find a coupon
                            ->required(),
                    ])
                    ->action(function (Collection $records, array $data) {
                        // Get the selected coupon
                        $coupon = Coupon::find($data['coupon_id']);

                        // Assign the coupon to the selected users
                        $coupon->users()->attach($records->pluck('id'));

                        // Notify the admin
                        \Filament\Notifications\Notification::make()
                            ->title('Coupon Assigned')
                            ->body("Coupon {$coupon->code} assigned to " . $records->count() . " users.")
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    protected function sendCertificateEmail(array $data)
    {
        $response = Http::post('https://cimso-golf-booking-demo.onrender.com/v1/api/emails/send-email-certificate', $data);

        if ($response->successful()) {
            return true;
        }

        throw new \Exception('Failed to send certificate email: ' . $response->body());
    }

}
