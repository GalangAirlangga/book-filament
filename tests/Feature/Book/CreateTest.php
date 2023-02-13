<?php

use App\Filament\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use function Pest\Faker\faker;
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

it('can generate slug', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'isbn' => $newData->isbn,
            'title' => $newData->title,
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

it('can ensure validation "title" is required', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'isbn' => $newData->isbn,
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
        ->assertHasFormErrors(['title' => 'required']);
});

it('can ensure validation "title" is min 3', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'isbn' => $newData->isbn,
            'title' => '12',
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
        ->assertHasFormErrors(['title' => 'min']);
});

it('can ensure validation "image" is required', function () {
    $newData = Book::factory()->make();

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
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
        ])
        ->call('create')
        ->assertHasFormErrors(['image' => 'required']);
});

it('can ensure validation "selling_price" is numeric', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
            'slug' => $newData->slug,
            'category_id' => $newData->category_id,
            'publisher_id' => $newData->publisher_id,
            'selling_price' => 'asdasd',
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
        ->assertHasFormErrors(['selling_price' => 'numeric']);
});

it('can ensure validation "selling_price" is required', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
            'slug' => $newData->slug,
            'category_id' => $newData->category_id,
            'publisher_id' => $newData->publisher_id,
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
        ->assertHasFormErrors(['selling_price' => 'required']);
});

it('can ensure validation "buying_price" is numeric', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
            'slug' => $newData->slug,
            'category_id' => $newData->category_id,
            'publisher_id' => $newData->publisher_id,
            'selling_price' => $newData->selling_price,
            'buying_price' => 'asdasd',
            'stock' => $newData->stock,
            'description' => $newData->description,
            'image' => $file,
            'book_page' => $newData->book_page,
            'weight' => $newData->weight,
            'type_cover' => $newData->type_cover,
            'is_visible' => $newData->is_visible,
        ])
        ->call('create')
        ->assertHasFormErrors(['buying_price' => 'numeric']);
});

it('can ensure validation "buying_price" is required', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
            'slug' => $newData->slug,
            'category_id' => $newData->category_id,
            'publisher_id' => $newData->publisher_id,
            'selling_price' => $newData->selling_price,
            'stock' => $newData->stock,
            'description' => $newData->description,
            'image' => $file,
            'book_page' => $newData->book_page,
            'weight' => $newData->weight,
            'type_cover' => $newData->type_cover,
            'is_visible' => $newData->is_visible,
        ])
        ->call('create')
        ->assertHasFormErrors(['buying_price' => 'required']);
});

it('can ensure validation "isbn" is numeric', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => 'asdasd',
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
        ->assertHasFormErrors(['isbn' => 'numeric']);
});

it('can ensure validation "isbn" is required', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
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
        ->assertHasFormErrors(['isbn' => 'required']);
});

it('can ensure validation "isbn" is max length 13', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'isbn' => 123456789012345,
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
        ->assertHasFormErrors(['isbn'=>'max_digits']); //I still haven't found the key for maxlength
});

it('can ensure validation "stock" is numeric', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
            'slug' => $newData->slug,
            'category_id' => $newData->category_id,
            'publisher_id' => $newData->publisher_id,
            'selling_price' => $newData->selling_price,
            'buying_price' => $newData->buying_price,
            'stock' => 'asd',
            'description' => $newData->description,
            'image' => $file,
            'book_page' => $newData->book_page,
            'weight' => $newData->weight,
            'type_cover' => $newData->type_cover,
            'is_visible' => $newData->is_visible,
        ])
        ->call('create')
        ->assertHasFormErrors(['stock' => 'numeric']);
});

it('can ensure validation "book_page" is numeric', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
            'slug' => $newData->slug,
            'category_id' => $newData->category_id,
            'publisher_id' => $newData->publisher_id,
            'selling_price' => $newData->selling_price,
            'buying_price' => $newData->buying_price,
            'stock' => $newData->stock,
            'description' => $newData->description,
            'image' => $file,
            'book_page' => 'asdsad',
            'weight' => $newData->weight,
            'type_cover' => $newData->type_cover,
            'is_visible' => $newData->is_visible,
        ])
        ->call('create')
        ->assertHasFormErrors(['book_page' => 'numeric']);
});

it('can ensure validation "weight" is numeric', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
            'slug' => $newData->slug,
            'category_id' => $newData->category_id,
            'publisher_id' => $newData->publisher_id,
            'selling_price' => $newData->selling_price,
            'buying_price' => $newData->buying_price,
            'stock' => $newData->stock,
            'description' => $newData->description,
            'image' => $file,
            'book_page' => $newData->book_page,
            'weight' => 'asdsd',
            'type_cover' => $newData->type_cover,
            'is_visible' => $newData->is_visible,
        ])
        ->call('create')
        ->assertHasFormErrors(['weight' => 'numeric']);
});

it('can ensure validation "type_cover" is soft_cover or hard_cover', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
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
            'type_cover' => 'type_cover',
            'is_visible' => $newData->is_visible,
        ])
        ->call('create')
        ->assertHasFormErrors(['type_cover' => 'in']);
});

it('can ensure validation "is_visible" is boolean', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
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
            'is_visible' => 'asdsad',
        ])
        ->call('create')
        ->assertHasFormErrors(['is_visible' => 'boolean']);
});

it('can ensure validation "category_id" is required', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
            'slug' => $newData->slug,
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
        ->assertHasFormErrors(['category_id' => 'required']);
});

it('can ensure validation "publisher_id" is required', function () {
    $newData = Book::factory()->make();


    $file = UploadedFile::fake()->image('books.png');

    livewire(BookResource\Pages\CreateBook::class)
        ->fillForm([
            'title' => $newData->title,
            'isbn' => $newData->isbn,
            'slug' => $newData->slug,
            'category_id' => $newData->category_id,
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
        ->assertHasFormErrors(['publisher_id' => 'required']);
});
