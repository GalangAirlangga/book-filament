<?php

use App\Filament\Resources\TransactionsResource\Pages\ListTransactions;
use App\Models\Transactions;
use App\Models\User;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(
        User::factory()->create()
    );
});

it('can delete', function () {
    $transaction = Transactions::factory()->create();

    livewire(ListTransactions::class, [
        'record' => $transaction->getKey(),
    ])
        ->callTableAction(DeleteAction::class,$transaction);

    $this->assertModelMissing($transaction);
});
