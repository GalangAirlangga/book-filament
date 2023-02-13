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

it('can render page', function () {
    $this->get(BookResource::getUrl('edit', [
        'record' => Book::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $book = Book::factory()->create();

    livewire(BookResource\Pages\EditBook::class, [
        'record' => $book->getKey(),
    ])
        ->assertFormSet([
            'isbn' => $book->isbn,
            'title' => $book->title,
            'slug' => $book->slug,
            'category_id' => $book->category_id,
            'publisher_id' => $book->publisher_id,
            'selling_price' => $book->selling_price,
            'buying_price' => $book->buying_price,
            'stock' => $book->stock,
            'description' => $book->description,
            'book_page' => $book->book_page,
            'weight' => $book->weight,
            'type_cover' => $book->type_cover,
            'is_visible' => $book->is_visible,
        ]);
});

it('can save', function () {
    $book = Book::factory()->create();
    $newData = Book::factory()->make();

    $file = UploadedFile::fake()->image('books.png');
    livewire(BookResource\Pages\EditBook::class, [
        'record' => $book->getKey(),
    ])
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
        ->call('save')
        ->assertHasNoFormErrors();

    expect($book->refresh())
        ->category_id->toBe($newData->category_id)
        ->publisher_id->toBe($newData->publisher_id)
        ->isbn->toBe($newData->isbn)
        ->title->toBe($newData->title)
        ->slug->toBe($newData->slug)
        ->selling_price->toBe($newData->selling_price)
        ->buying_price->toBe($newData->buying_price)
        ->stock->toBe($newData->stock)
        ->description->toBe($newData->description)
        ->book_page->toBe($newData->book_page)
        ->weight->toBe($newData->weight)
        ->type_cover->toBe($newData->type_cover)
        ->is_visible->toBe($newData->is_visible);
});




