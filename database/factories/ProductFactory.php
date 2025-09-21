<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = ucwords($this->faker->words(3, true));
        $price = $this->faker->numberBetween(25, 200) * 1000;
        return [
            // Ambil ID kategori secara acak dari yang sudah ada
            'category_id' => ProductCategory::inRandomOrder()->first()->id,
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::lower(Str::random(4)),
            'sku' => 'ARA-' . $this->faker->unique()->numberBetween(1000, 9999),
            'description' => $this->faker->paragraph(3),
            'price' => $price,
            'preparation_time_days' => $this->faker->numberBetween(2, 5),
            'is_available' => true,
            'image_url' => null,
            'is_recommended' => $this->faker->boolean(25), // 25% kemungkinan jadi produk rekomendasi
            'is_featured' => $this->faker->boolean(15),    // 15% kemungkinan jadi produk unggulan
            'is_active' => true,
        ];
    }
}
