<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Package Information")
                    ->schema([
                TextInput::make('name')
                    ->label('Package Name')
                    ->placeholder('Enter package name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('price')
                    ->label('Price')
                    ->placeholder('Enter price')
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->minValue(0),

                Repeater::make('features')
                    ->label('Features')
                    ->schema([
                        TextInput::make('feature')
                            ->label('Feature')
                            ->placeholder('Enter a feature')
                            ->required(),
                    ])
                    ->defaultItems(1) // Start with 1 feature field
                    ->addActionLabel('Add Feature') // Label for the "Add" button
                    ->collapsible() // Allow collapsing the repeater
                    ->columnSpan(2)
                    ->helperText('Add all the features included in this package.'),
                    ])
                    ->columnSpan(['lg' => 2]),

                Section::make("Visibility & Status")
                    ->schema([
                        Toggle::make('visibility')
                            ->label('Visibility')
                            ->helperText('Enable to display this course on the website')
                            ->default(true),

                        Toggle::make('is_featured')
                            ->label('Featured')
                            ->helperText('Enable to highlight this course as a featured one')
                            ->default(false),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Package Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('price')
                    ->label('Price')
                    ->sortable()
                    ->money('THB'), // Format as Thai Baht

                TextColumn::make('features')
                    ->label('Features')
                    ->formatStateUsing(function ($state) {
                        // Convert JSON to a comma-separated string
                        return implode(', ', json_decode($state, true));
                    })
                    ->limit(50) // Limit the display length
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state; // Show full text on hover
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
