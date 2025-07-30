<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua kategori
        $categories = ProductCategory::where('is_active', true)->get();

        foreach ($categories as $category) {
            // Buat 5 produk per kategori
            for ($i = 0; $i < 5; $i++) {
                $productName = match ($category->slug) {
                    'donat' => $faker->randomElement(['Donat Coklat', 'Donat Keju', 'Donat Matcha', 'Donat Stroberi', 'Donat Gula']),
                    'snack-box' => $faker->randomElement(['Snack Box Mini', 'Snack Box Premium', 'Snack Box Rapat', 'Snack Box Komplit']),
                    'nasi-box' => $faker->randomElement(['Nasi Ayam Bakar', 'Nasi Rendang', 'Nasi Ayam Geprek', 'Nasi Ikan Bakar']),
                    default => $faker->words(3, true)
                };

                DB::table('products')->insert([
                    'category_id' => $category->id,
                    'name' => $productName,
                    'slug' => Str::slug($productName) . '-' . Str::random(5),
                    'sku' => strtoupper(Str::random(8)),
                    'description' => $faker->sentence(10),
                    'price' => $faker->numberBetween(15000, 50000),
                    'stock' => $faker->numberBetween(10, 100),
                    'preparation_time_days' => $faker->numberBetween(1, 3),
                    'is_available' => true,
                    'is_preorder_only' => false,
                    'image_url' => null,
                    'is_recommended' => $faker->boolean(30),
                    'is_featured' => $faker->boolean(20),
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
