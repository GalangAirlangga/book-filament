<?php

use App\Filament\Resources\BookResource;
use App\Filament\Resources\CategoryResource;
use App\Models\Book;
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
    $this->get(BookResource::getUrl())->assertSuccessful();
});


it('can list book', function () {
    $book = Book::factory()->count(10)->create();
    livewire(BookResource\Pages\ListBooks::class)
        ->assertCanSeeTableRecords($book);
});
