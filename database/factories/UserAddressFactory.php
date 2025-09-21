<?php

namespace Database\Factories;

use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{
    protected $model = UserAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // user_id akan kita isi dari Seeder
            'address_line1' => $this->faker->streetAddress,
            'address_line2' => $this->faker->secondaryAddress, // Lebih cocok untuk No. Rumah/Blok
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'is_default' => false, // Default-nya false, kita atur di seeder
        ];
    }
}
