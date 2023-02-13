<?php

use App\Filament\Resources\BookResource\Pages\EditBook;
use App\Models\Book;
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
    $book = Book::factory()->create();

    livewire(EditBook::class, [
        'record' => $book->getKey(),
    ])
        ->callPageAction(DeleteAction::class);

    $this->assertModelMissing($book);
});
