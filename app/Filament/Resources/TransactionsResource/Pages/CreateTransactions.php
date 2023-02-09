<?php

namespace App\Filament\Resources\TransactionsResource\Pages;

use App\Filament\Resources\TransactionsResource;
use App\Models\Transactions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransactions extends CreateRecord
{
    protected static string $resource = TransactionsResource::class;

    protected function afterCreate(): void
    {
        $transaction = Transactions::with('transactionItems.book')->whereNumber($this->record->number)->first();
        foreach ($transaction->transactionItems as $item){
            $item->book->stock -= $item->quantity;
            $item->book->save();
        }

    }
}
