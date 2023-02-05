<?php

namespace App\Filament\Resources\PublisherResource\Pages;

use App\Filament\Resources\PublisherResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPublishers extends ListRecords
{
    protected static string $resource = PublisherResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
