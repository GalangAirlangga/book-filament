<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Fiction','slug'=>'fiction'],
            ['name' => 'Non-Fiction','slug'=>'non-fiction'],
            ['name' => 'Children','slug'=>'children'],
            ['name' => 'Young Adult','slug'=>'young-adult'],
            ['name' => 'Science','slug'=>'science'],
            ['name' => 'Technology','slug'=>'technology'],
            ['name' => 'Cooking','slug'=>'cooking'],
            ['name' => 'Self Help','slug'=>'self-help'],
            ['name' => 'Travel','slug'=>'travel'],
        ];

        collect($categories)->each(fn($category) => Category::create($category));
    }
}
