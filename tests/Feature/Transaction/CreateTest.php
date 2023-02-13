<?php

use App\Filament\Resources\BookResource;
use App\Filament\Resources\TransactionsResource;
use App\Models\Book;
use App\Models\TransactionItem;
use App\Models\Transactions;
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
    $this->get(TransactionsResource::getUrl('create'))->assertSuccessful();
});

it('can create', function () {
    $newData = Transactions::factory()->make();



    livewire(TransactionsResource\Pages\CreateTransactions::class)
        ->fillForm([
            'number' => $newData->number,
            'date' => $newData->date,
            'total_price' => $newData->total_price,
            'type_payment' => $newData->type_payment,
            'note' => $newData->note,
            'transactionItems'=> $newData->transactionItems

        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Transactions::class, [
        'number' => $newData->number,
        'date' => $newData->date,
        'total_price' => $newData->total_price,
        'type_payment' => $newData->type_payment,
        'note' => $newData->note,
    ]);
    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $newData->transactionItems);

});

it('can ensure validation "type_payment" is required', function () {
    $newData = Transactions::factory()->make();



    livewire(TransactionsResource\Pages\CreateTransactions::class)
        ->fillForm([
            'number' => $newData->number,
            'date' => $newData->date,
            'total_price' => $newData->total_price,
            'note' => $newData->note,
            'transactionItems'=> $newData->transactionItems

        ])
        ->call('create')
        ->assertHasFormErrors(['type_payment'=>'required']);

});

it('can ensure validation "transactionItems" is required', function () {
    $newData = Transactions::factory()->make();



    livewire(TransactionsResource\Pages\CreateTransactions::class)
        ->fillForm([
            'number' => $newData->number,
            'date' => $newData->date,
            'total_price' => $newData->total_price,
            'type_payment' => $newData->type_payment,
            'note' => $newData->note,
            'transactionItems'=> [
                [
                    'quantity'=>2,
                    'unit_price'=>1000
                ]
            ]
        ])
        ->call('create')
        ->assertHasFormErrors(['transactionItems.*.book_id']);

});


