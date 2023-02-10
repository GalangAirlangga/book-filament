<?php

use App\Filament\Resources\PublisherResource\Pages\EditPublisher;
use App\Models\Publisher;
use App\Models\User;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(
        User::factory()->create()
    );
});

it('can delete', function () {
    $publisher = Publisher::factory()->create();

    livewire(EditPublisher::class, [
        'record' => $publisher->getKey(),
    ])
        ->callPageAction(DeleteAction::class);

    $this->assertModelMissing($publisher);
});
