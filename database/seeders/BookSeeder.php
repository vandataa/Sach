<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        \App\Models\Category::factory(10)->create();
        \App\Models\Publisher::factory(10)->create();
        \App\Models\Book::factory(10)->create();
    }
}
