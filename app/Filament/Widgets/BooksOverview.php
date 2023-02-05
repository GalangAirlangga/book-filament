<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class BooksOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getCards(): array
    {
        $totalBooks = Book::count();
        $totalBooksMinimum = Book::where('stock','<=',5)->count();
        $averagePriceBook = Book::avg('selling_price');
        return [
            Card::make('Number of books', $totalBooks)
                ->description('by title'),
            Card::make('Books with minimum stock', $totalBooksMinimum)
                ->description('by title'),
            Card::make('Average book price', round($averagePriceBook))
                ->description('by selling price'),
        ];
    }
}
