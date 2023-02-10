<?php

use App\Filament\Resources\CategoryResource;
use App\Models\Category;
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
    $this->get(CategoryResource::getUrl('create'))->assertSuccessful();
});

it('can create', function () {
    $newData = Category::factory()->make();
    $newData = [
        'name' => $newData->name,
        'slug' => $newData->slug,
        'description' => $newData->description,
        'is_visible' => $newData->is_visible,
    ];
    livewire(CategoryResource\Pages\CreateCategory::class)
        ->fillForm($newData)
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Category::class, $newData);
});

it('can generate slugs automatically', function () {
    $newData = Category::factory()->make();
    $newData = [
        'name' => $newData->name,
        'description' => $newData->description,
        'is_visible' => $newData->is_visible,
    ];
    livewire(CategoryResource\Pages\CreateCategory::class)
        ->fillForm($newData)
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Category::class, $newData);
});

it('can ensure validation "name" is required', function () {

    livewire(CategoryResource\Pages\CreateCategory::class)
        ->fillForm([
            'name' => null,
        ])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required']);
});

it('can ensure validation "slug" is unique.', function () {
    $newData = Category::factory()->create();
    livewire(CategoryResource\Pages\CreateCategory::class)
        ->fillForm([
            'name' => $newData->name,
            'slug'=>$newData->slug
        ])
        ->call('create')
        ->assertHasFormErrors(['slug'=>'unique']);
});

