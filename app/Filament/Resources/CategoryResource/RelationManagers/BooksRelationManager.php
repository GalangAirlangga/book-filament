<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Models\Book;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class BooksRelationManager extends RelationManager
{
    protected static string $relationship = 'books';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('isbn')
                    ->required(),

                TextInput::make('title')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->disabled()
                    ->unique(Book::class, 'slug', fn($record) => $record),

                Select::make('publisher_id')
                    ->relationship('publisher', 'name')
                    ->searchable(),

                TextInput::make('selling_price')
                    ->required()
                    ->numeric(),

                TextInput::make('buying_price')
                    ->numeric(),

                TextInput::make('stock')
                    ->required()
                    ->integer(),

                TextInput::make('description'),

                TextInput::make('book_page')
                    ->integer(),

                TextInput::make('weight')
                    ->numeric(),

                TextInput::make('type_cover')
                    ->required(),

                Checkbox::make('is_visible'),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Book $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Book $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('isbn'),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('publisher.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('selling_price'),

                TextColumn::make('buying_price'),

                TextColumn::make('stock'),

                TextColumn::make('description'),

                ImageColumn::make('image'),

                TextColumn::make('book_page'),

                TextColumn::make('weight'),

                TextColumn::make('type_cover'),

                TextColumn::make('is_visible'),
            ]);
    }
}
