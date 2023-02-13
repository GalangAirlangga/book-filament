<?php

namespace Database\Factories;

use App\Models\TransactionItem;
use App\Models\Book;
use App\Models\Transactions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransactionsFactory extends Factory
{
    private static int $order = 1;

    protected $model = Transactions::class;

    public function definition(): array
    {
        $dateTransaction = Carbon::now()->format('Y-m-d');
        Book::factory()->count(10)->create();
        return [
            'number' => 'TRX-' . $dateTransaction . '-' . self::$order++,
            'date' =>  $dateTransaction,
            'type_payment' => $this->faker->randomElement(['cash', 'debit', 'credit']),
            'note' => 'test',
            'total_price'=>0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Transactions $transaction) {
            $books = Book::pluck('id');
            $total_price = 0;
            $quantity = rand(1, 3);
            for ($i = 0; $i < $quantity; $i++) {
                $book_id = $books[array_rand($books->toArray())];
                $unit_price = Book::where('id', $book_id)->value('selling_price');
                $qty = rand(1, 3);

                $transactionItem = TransactionItem::factory()->make([
                    'transaction_id' => $transaction->id,
                    'book_id' => $book_id,
                    'quantity' => $qty,
                    'unit_price' => $unit_price,
                ]);

                $transaction->transactionItems()->save($transactionItem);
                $total_price += $unit_price * $qty;
            }

            $transaction->update(['total_price' => $total_price]);
        });
    }
}
