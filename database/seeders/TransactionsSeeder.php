<?php

namespace Database\Seeders;

use App\Models\Transactions;
use DB;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $books = DB::table('books')->pluck('id');
        for ($i = 0; $i < 750; $i++) {
            $dateTransaction = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d');
            $transaction = DB::table('transactions')->insertGetId([
                'number' => 'TRX-' . $dateTransaction . '-' . ($i + 1),
                'date' =>  $dateTransaction,
                'type_payment' => $faker->randomElement(['cash', 'debit', 'credit']),
                'note' => 'test',
                'total_price'=>0,
                'created_at' => $dateTransaction,
                'updated_at' => now(),
            ]);

            $total_price = 0;
            $quantity = rand(1, 3);
            for ($j = 0; $j < $quantity; $j++) {
                $book_id = $books[array_rand($books->toArray())];
                $unit_price = DB::table('books')->where('id', $book_id)->value('selling_price');
                $qty = rand(1, 3);
                DB::table('transaction_items')->insert([
                    'transaction_id' => $transaction,
                    'book_id' => $book_id,
                    'quantity' => $qty,
                    'unit_price' => $unit_price,
                    'created_at' => $dateTransaction,
                    'updated_at' => now(),
                ]);
                $total_price += $unit_price * $qty;
            }

            DB::table('transactions')
                ->where('id', $transaction)
                ->update(['total_price' => $total_price]);
        }
    }
}
