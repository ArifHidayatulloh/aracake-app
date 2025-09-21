<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boluCategory = ProductCategory::where('slug', 'kue-bolu')->first();
        $donatCategory = ProductCategory::where('slug', 'donat')->first();
        $keringCategory = ProductCategory::where('slug', 'kue-kering')->first();
        $snackBoxCategory = ProductCategory::where('slug', 'snack-box')->first();
        $nasiBoxCategory = ProductCategory::where('slug', 'nasi-box')->first();
        $ultahCategory = ProductCategory::where('slug', 'kue-ulang-tahun')->first();

        // Produk Kue Bolu
        if ($boluCategory) {
            Product::factory()->create([
                'category_id' => $boluCategory->id,
                'name' => 'Bolu Pandan Premium',
                'slug' => 'bolu-pandan-premium',
                'price' => 75000,
                'is_featured' => true,
                'is_recommended' => true,
            ]);
            Product::factory()->create([
                'category_id' => $boluCategory->id,
                'name' => 'Bolu Gulung Coklat Keju',
                'slug' => 'bolu-gulung-coklat-keju',
                'price' => 85000,
            ]);
        }

        // Produk Donat
        if ($donatCategory) {
            Product::factory()->create([
                'category_id' => $donatCategory->id,
                'name' => 'Donat Kentang Original',
                'slug' => 'donat-kentang-original',
                'price' => 30000,
                'is_recommended' => true,
            ]);
            Product::factory()->create([
                'category_id' => $donatCategory->id,
                'name' => 'Donat Coklat Sprinkle',
                'slug' => 'donat-coklat-sprinkle',
                'price' => 35000,
            ]);
        }

        // Produk Kue Kering
        if ($keringCategory) {
            Product::factory()->create([
                'category_id' => $keringCategory->id,
                'name' => 'Nastar Klasik Wijsman',
                'slug' => 'nastar-klasik-wijsman',
                'price' => 150000,
                'is_featured' => true,
            ]);
            Product::factory()->create([
                'category_id' => $keringCategory->id,
                'name' => 'Kastengel Keju Edam',
                'slug' => 'kastengel-keju-edam',
                'price' => 165000,
            ]);
        }

        // Produk Snack Box
        if ($snackBoxCategory) {
            Product::factory()->create([
                'category_id' => $snackBoxCategory->id,
                'name' => 'Snack Box Mini',
                'slug' => 'snack-box-mini',
                'price' => 25000,
            ]);
            Product::factory()->create([
                'category_id' => $snackBoxCategory->id,
                'name' => 'Snack Box Deluxe',
                'slug' => 'snack-box-deluxe',
                'price' => 40000,
                'is_recommended' => true,
            ]); 
        }

        // Produk Nasi Box
        if ($nasiBoxCategory) {
            Product::factory()->create([
                'category_id' => $nasiBoxCategory->id,
                'name' => 'Nasi Box Ayam Bakar',
                'slug' => 'nasi-box-ayam-bakar',
                'price' => 40000,
                'is_featured' => true,
            ]);
            Product::factory()->create([
                'category_id' => $nasiBoxCategory->id,
                'name' => 'Nasi Box Rendang',
                'slug' => 'nasi-box-rendang',
                'price' => 45000,
            ]);
        }

        // Produk Kue Ulang Tahun
        if ($ultahCategory) {
            Product::factory()->create([
                'category_id' => $ultahCategory->id,
                'name' => 'Kue Ulang Tahun Coklat',
                'slug' => 'kue-ulang-tahun-coklat',
                'price' => 200000,
                'is_featured' => true,
                'is_recommended' => true,
            ]);
            Product::factory()->create([
                'category_id' => $ultahCategory->id,
                'name' => 'Kue Ulang Tahun Red Velvet',
                'slug' => 'kue-ulang-tahun-red-velvet',
                'price' => 220000,
            ]); 
        }

        Product::factory()->count(10)->create();
    }
}
