<?php

use App\Filament\Resources\TransactionsResource;
use App\Models\Book;
use App\Models\Transactions;
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
    $this->get(TransactionsResource::getUrl())->assertSuccessful();
});


it('can list transaction', function () {

    $transaction = Transactions::factory()->count(10)->create();
    livewire(TransactionsResource\Pages\ListTransactions::class)
        ->assertCanSeeTableRecords($transaction);
});
