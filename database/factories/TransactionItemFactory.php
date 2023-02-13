<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\TransactionItem;
use App\Models\Transactions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransactionItemFactory extends Factory
{
    protected $model = TransactionItem::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber(),
            'unit_price' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'transaction_id' => Transactions::factory(),
            'book_id' => Book::factory(),
        ];
    }
}
