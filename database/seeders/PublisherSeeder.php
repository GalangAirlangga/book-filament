<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    public function run()
    {
        $publishers = [
            ['name' => 'Penguin', 'slug' => 'penguin'],
            ['name' => 'HarperCollins', 'slug' => 'harpercollins'],
            ['name' => 'Simon & Schuster', 'slug' => 'simon-schuster'],
            ['name' => 'Hachette', 'slug' => 'hachette'],
            ['name' => 'Random House', 'slug' => 'random-house'],
            ['name' => 'Scholastic', 'slug' => 'scholastic'],
            ['name' => 'Macmillan', 'slug' => 'macmillan'],
            ['name' => 'Wiley', 'slug' => 'wiley'],
            ['name' => 'Springer', 'slug' => 'springer'],
        ];

        collect($publishers)->each(fn($publisher) => Publisher::create($publisher));
    }
}
