<?php

namespace App\Filament\Resources\TransactionsResource\RelationManagers;

use App\Models\TransactionItem;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class TransactionItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactionItems';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('book_id')
                    ->relationship('book', 'title')
                    ->searchable(),

                TextInput::make('quantity')
                    ->required()
                    ->integer(),

                TextInput::make('unit_price')
                    ->required()
                    ->numeric(),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?TransactionItem $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?TransactionItem $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('book.title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('quantity'),

                TextColumn::make('unit_price'),
            ]);
    }
}
