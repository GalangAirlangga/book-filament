<?php

use App\Filament\Resources\PublisherResource;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(
        User::factory()->create()
    );
});

it('can render page index', function () {
    $this->get(PublisherResource::getUrl())->assertSuccessful();
});


it('can list publisher', function () {
    $publisher = Publisher::factory()->count(10)->create();
    livewire(PublisherResource\Pages\ListPublishers::class)
        ->assertCanSeeTableRecords($publisher);
});
