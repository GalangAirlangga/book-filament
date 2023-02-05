<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublisherResource\Pages;
use App\Filament\Resources\PublisherResource\RelationManagers\BooksRelationManager;
use App\Models\Publisher;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class PublisherResource extends Resource
{
    protected static ?string $model = Publisher::class;

    protected static ?string $slug = 'publishers';

    protected static ?string $navigationIcon = 'heroicon-o-office-building';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->disabled()
                    ->unique(Publisher::class, 'slug', fn($record) => $record),

                Toggle::make('is_visible')
                    ->label('Visible to users.')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_visible')
                    ->boolean()
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Visibility')
                    ->sortable(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BooksRelationManager::class,
        ];
    }

    public static function getPages():array
    {
        return [
            'index' => Pages\ListPublishers::route('/'),
            'create' => Pages\CreatePublisher::route('/create'),
            'edit' => Pages\EditPublisher::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes():array
    {
        return ['name', 'slug'];
    }
}
