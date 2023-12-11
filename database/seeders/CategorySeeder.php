<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['entertainment', 'general', 'health', 'science', 'sports', 'technology'];
        foreach ($categories as $category) {
            Category::factory()->create([
                'name' => $category
            ]);
        }
    }
}
