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

it('can render page', function () {
    $this->get(PublisherResource::getUrl('edit', [
        'record' => Publisher::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $publisher = Publisher::factory()->create();

    livewire(PublisherResource\Pages\EditPublisher::class, [
        'record' => $publisher->getKey(),
    ])
        ->assertFormSet([
            'name' => $publisher->name,
            'slug' => $publisher->slug,
            'is_visible' => $publisher->is_visible,
        ]);
});

it('can save', function () {
    $publisher = Publisher::factory()->create();
    $newData = Publisher::factory()->make();

    livewire(PublisherResource\Pages\EditPublisher::class, [
        'record' => $publisher->getKey(),
    ])
        ->fillForm([
            'name' => $newData->name,
            'slug' => $newData->slug,
            'is_visible' => $newData->is_visible,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($publisher->refresh())
        ->name->toBe($newData->name)
        ->slug->toBe($newData->slug)
        ->is_visible->toBe($newData->is_visible);
});

it('can ensure validation "name" is required', function () {
    $publisher = Publisher::factory()->create();

    livewire(PublisherResource\Pages\EditPublisher::class, [
        'record' => $publisher->getKey(),
    ])
        ->fillForm([
            'name' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['name' => 'required']);
});

it('can ensure validation "slug" is unique.', function () {
    $otherPublisher = Publisher::factory()->create();
    $publisher = Publisher::factory()->create();
    livewire(PublisherResource\Pages\EditPublisher::class, [
        'record' => $publisher->getKey(),
    ])
        ->fillForm([
            'name' => $publisher->name,
            'slug'=>$otherPublisher->slug
        ])
        ->call('save')
        ->assertHasFormErrors(['slug' => 'unique']);
});



