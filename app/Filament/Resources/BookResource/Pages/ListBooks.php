<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use App\Filament\Resources\BookResource\Widgets\BooksOverview;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            BooksOverview::class
        ];
    }
}
