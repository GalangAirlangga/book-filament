<?php

namespace App\Filament\Resources\PublisherResource\Pages;

use App\Filament\Resources\PublisherResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPublisher extends EditRecord
{
    protected static string $resource = PublisherResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
