<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake('id_ID')->name(),
            'username' => fake('id_ID')->unique()->userName(),
            'email' => fake('id_ID')->unique()->safeEmail(),
            'phone_number' => fake('id_ID')->phoneNumber(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // default password
            'role' => 'customer', // default role
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user){
            // Jika user yang dibuat adalah customer, otomatis buatkan keranjang belanja untuknya.
            if ($user->role === 'customer') {
                $user->cart()->create();
            }
        });
    }
}
