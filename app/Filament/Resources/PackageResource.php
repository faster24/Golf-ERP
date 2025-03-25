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
use Filament\Tables\Columns\IconColumn;
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
                    ->money('THB'),

                TextColumn::make('features')
                    ->label('Features')
                    ->formatStateUsing(function ($state) {
                        // Handle the malformed JSON string
                        if (!$state) {
                            return '-';
                        }

                        $features = explode(', ', str_replace(['\"', '{', '}'], '', $state));

                        $featureList = array_map(function ($item) {
                            $parts = explode(':', $item);
                            return $parts[1] ?? $item; // Get value after "feature:"
                        }, $features);

                        return implode(', ', $featureList);
                    }),

                IconColumn::make('visibility')
                    ->label('Visibility')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('danger'),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('amber'),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_featured')
                    ->label('Featured Courses')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true)),

                Tables\Filters\Filter::make('visibility')
                    ->label('Visible Courses')
                    ->query(fn (Builder $query): Builder => $query->where('visibility', true)),
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
