<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendeeResource\Pages;
use App\Filament\Resources\AttendeeResource\RelationManagers;
use App\Models\Attendee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Http;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Models\Customer;

class AttendeeResource extends Resource
{
    protected static ?string $model = Attendee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                TextColumn::make('tournament')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
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
                    ->action(function (array $data) {
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
            'index' => Pages\ListAttendees::route('/'),
            'create' => Pages\CreateAttendee::route('/create'),
            'edit' => Pages\EditAttendee::route('/{record}/edit'),
        ];
    }

   public static function canCreate(): bool
    {
        return false;
    }
}
