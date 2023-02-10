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

it('can render page', function () {
    $this->get(CategoryResource::getUrl('edit', [
        'record' => Category::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $category = Category::factory()->create();

    livewire(CategoryResource\Pages\EditCategory::class, [
        'record' => $category->getKey(),
    ])
        ->assertFormSet([
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'is_visible' => $category->is_visible,
        ]);
});

it('can save', function () {
    $category = Category::factory()->create();
    $newData = Category::factory()->make();

    livewire(CategoryResource\Pages\EditCategory::class, [
        'record' => $category->getKey(),
    ])
        ->fillForm([
            'name' => $newData->name,
            'slug' => $newData->slug,
            'description' => $newData->description,
            'is_visible' => $newData->is_visible,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($category->refresh())
        ->name->toBe($newData->name)
        ->slug->toBe($newData->slug)
        ->description->toBe($newData->description)
        ->is_visible->toBe($newData->is_visible);
});

it('can ensure validation "name" is required', function () {
    $category = Category::factory()->create();

    livewire(CategoryResource\Pages\EditCategory::class, [
        'record' => $category->getKey(),
    ])
        ->fillForm([
            'name' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['name' => 'required']);
});

it('can ensure validation "slug" is unique.', function () {
    $otherCategory = Category::factory()->create();
    $category = Category::factory()->create();
    livewire(CategoryResource\Pages\EditCategory::class, [
        'record' => $category->getKey(),
    ])
        ->fillForm([
            'name' => $category->name,
            'slug'=>$otherCategory->slug
        ])
        ->call('save')
        ->assertHasFormErrors(['slug' => 'unique']);
});



