<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'isbn' => $this->faker->isbn13,
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'category_id' => Category::factory(),
            'publisher_id' => Publisher::factory(),
            'selling_price' => $this->faker->numberBetween(10000, 100000),
            'buying_price' => $this->faker->numberBetween(5000, 90000),
            'stock' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
            'book_page' => $this->faker->numberBetween(100, 1000),
            'weight' => $this->faker->randomFloat(2, 0, 5),
            'type_cover' => $this->faker->randomElement(['hard_cover', 'soft_cover']),
            'is_visible' => $this->faker->randomElement([1,0]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
