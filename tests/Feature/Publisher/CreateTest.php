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

it('can render page create', function () {
    $this->get(PublisherResource::getUrl('create'))->assertSuccessful();
});

it('can create', function () {
    $newData = Publisher::factory()->make();
    $newData = [
        'name' => $newData->name,
        'slug' => $newData->slug,
        'is_visible' => $newData->is_visible,
    ];
    livewire(PublisherResource\Pages\CreatePublisher::class)
        ->fillForm($newData)
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Publisher::class, $newData);
});

it('can generate slugs automatically', function () {
    $newData = Publisher::factory()->make();
    $newData = [
        'name' => $newData->name,
        'is_visible' => $newData->is_visible,
    ];
    livewire(PublisherResource\Pages\CreatePublisher::class)
        ->fillForm($newData)
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Publisher::class, $newData);
});

it('can ensure validation "name" is required', function () {

    livewire(PublisherResource\Pages\CreatePublisher::class)
        ->fillForm([
            'name' => null,
        ])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required']);
});

it('can ensure validation "slug" is unique.', function () {
    $newData = Publisher::factory()->create();
    livewire(PublisherResource\Pages\CreatePublisher::class)
        ->fillForm([
            'name' => $newData->name,
            'slug'=>$newData->slug
        ])
        ->call('create')
        ->assertHasFormErrors(['slug'=>'unique']);
});

