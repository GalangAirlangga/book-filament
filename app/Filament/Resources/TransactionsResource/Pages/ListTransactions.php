<?php

namespace App\Filament\Resources\TransactionsResource\Pages;

use App\Filament\Resources\TransactionsResource;
use App\Filament\Resources\TransactionsResource\Widgets\TransactionOverview;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionsResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
           TransactionOverview::class,
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'number';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';

    }
}
