<?php

use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Models\Category;
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
    $category = Category::factory()->create();

    livewire(EditCategory::class, [
        'record' => $category->getKey(),
    ])
        ->callPageAction(DeleteAction::class);

    $this->assertModelMissing($category);
});
