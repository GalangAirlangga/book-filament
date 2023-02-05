<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Faker\Factory;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $categories = Category::all();
        $publishers = Publisher::all();

        collect(range(1, 50))->each(fn($i) => Book::create([
            'isbn' => $faker->isbn13,
            'title' => $faker->sentence,
            'slug' => $faker->slug,
            'category_id' => $faker->randomElement($categories)->id,
            'publisher_id' => $faker->randomElement($publishers)->id,
            'selling_price' => $faker->numberBetween(10000, 100000),
            'buying_price' => $faker->numberBetween(5000, 90000),
            'stock' => $faker->numberBetween(0, 100),
            'description' => $faker->paragraph,
            'image' => $faker->imageUrl(),
            'book_page' => $faker->numberBetween(100, 1000),
            'weight' => $faker->randomFloat(2, 0, 5),
            'type_cover' => $faker->randomElement(['hard_cover', 'soft_cover']),
            'is_visible' => $faker->boolean,
        ]));
    }
}
