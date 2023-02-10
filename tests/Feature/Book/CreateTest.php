<?php

use App\Filament\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(
        User::factory()->create()
    );
});

it('can render page create', function () {
    $this->get(BookResource::getUrl('create'))->assertSuccessful();
});

it('can create', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'isbn' => $newData->isbn,
            'title' => $newData->title,
            'slug' => $newData->slug,
            'category_id' => $newData->category_id,
            'publisher_id' => $newData->publisher_id,
            'selling_price' => $newData->selling_price,
            'buying_price' => $newData->buying_price,
            'stock' => $newData->stock,
            'description' => $newData->description,
            'image' => $file,
            'book_page' => $newData->book_page,
            'weight' => $newData->weight,
            'type_cover' => $newData->type_cover,
            'is_visible' => $newData->is_visible,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Book::class, [
        'isbn' => $newData->isbn,
        'title' => $newData->title,
        'slug' => $newData->slug,
        'category_id' => $newData->category_id,
        'publisher_id' => $newData->publisher_id,
        'selling_price' => $newData->selling_price,
        'buying_price' => $newData->buying_price,
        'stock' => $newData->stock,
        'description' => $newData->description,
        'book_page' => $newData->book_page,
        'weight' => $newData->weight,
        'type_cover' => $newData->type_cover,
        'is_visible' => $newData->is_visible,
    ]);

});

