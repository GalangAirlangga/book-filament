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

it('can render page index', function () {
    $this->get(CategoryResource::getUrl())->assertSuccessful();
});


it('can list category', function () {
    $category = Category::factory()->count(10)->create();
    livewire(CategoryResource\Pages\ListCategories::class)
        ->assertCanSeeTableRecords($category);
});
