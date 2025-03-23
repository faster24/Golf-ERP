<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoursesResource\Pages;
use App\Filament\Resources\CoursesResource\RelationManagers;
use App\Models\Courses;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CoursesResource extends Resource
{
    protected static ?string $model = Courses::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Course Infomations")
                    ->schema([

                        Grid::make(2)
                            ->schema([
                                TextInput::make('course_name')
                                    ->label('Course Name')
                                    ->placeholder('Enter course title')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('sub_description')
                                    ->label('Short Description')
                                    ->placeholder('Brief course summary')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                            Grid::make(2)
                                ->schema([
                                    TextInput::make('yard')
                                        ->label('Yard')
                                        ->placeholder('Enter yard info')
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('location_city')
                                        ->label('City')
                                        ->placeholder('Enter city name')
                                        ->required()
                                        ->maxLength(255),
                                ]),

                                TextInput::make('location_country')
                                    ->label('Country')
                                    ->placeholder('Enter country name')
                                    ->required()
                                    ->maxLength(255),

                                RichEditor::make('description')
                                    ->label('Description')
                                    ->placeholder('Provide a detailed course description')
                                    ->required(),

                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('rating')
                                            ->label('Rating')
                                            ->placeholder('Enter a rating (0 - 5)')
                                            ->numeric()
                                            ->step(0.1)
                                            ->minValue(0)
                                            ->maxValue(5)
                                            ->required(),

                                        TextInput::make('discount')
                                            ->label('Discount (%)')
                                            ->placeholder('Enter discount if applicable')
                                            ->numeric()
                                            ->step(0.1)
                                            ->minValue(0)
                                            ->default(0),
                                    ]),
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
                Tables\Columns\TextColumn::make('course_name')
                    ->label('Course Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('yard')
                    ->label('Yard')
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

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('discount')
                    ->label('Discount (%)')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('visibility')
                    ->label('Visibility')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourses::route('/create'),
            'edit' => Pages\EditCourses::route('/{record}/edit'),
        ];
    }
}
