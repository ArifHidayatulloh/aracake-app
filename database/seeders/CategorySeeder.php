<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Kue Bolu',
            'Donat',
            'Kue Kering',
            'Snack Box',
            'Nasi Box',
            'Kue Ulang Tahun'
        ];

        foreach ($categories as $categoryName) {
            ProductCategory::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'description' => "Berbagai pilihan produk dalam kategori {$categoryName} dari Ara Cake.",
                'is_active' => true,
            ]);
        }
    }
}
