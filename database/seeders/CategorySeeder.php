<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Donat',
                'slug' => 'donat',
                'description' => 'Donat yang mengandung berbagai macam rasa dan tekstur.',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Snack Box',
                'slug' => 'snack-box',
                'description' => 'Snack box yang mengandung berbagai macam makanan dan minuman.',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Nasi Box',
                'slug' => 'nasi-box',
                'description' => 'Nasi box yang mengandung berbagai macam makanan dan minuman.',
                'image' => null,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('product_categories')->insert($category);
        }
    }
}
