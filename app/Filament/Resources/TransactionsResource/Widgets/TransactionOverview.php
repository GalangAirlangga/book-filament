<?php

namespace App\Filament\Resources\TransactionsResource\Widgets;

use App\Models\TransactionItem;
use App\Models\Transactions;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
class TransactionOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $totalTransaction = Transactions::count();
        $totalProfit = TransactionItem::selectRaw('SUM(transaction_items.unit_price * transaction_items.quantity - books.buying_price * transaction_items.quantity) AS total_profit')
            ->join('books', 'transaction_items.book_id', '=', 'books.id')
            ->first()
            ->total_profit;
        $averagePrice = Transactions::avg('total_price');
        return [
            Card::make('Total Transaction', $totalTransaction),
            Card::make('Total Profit', $totalProfit),
            Card::make('Average Price', round($averagePrice)),
        ];
    }


}
