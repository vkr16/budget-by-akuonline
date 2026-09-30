<?php

namespace Database\Factories;

use App\Models\Pocket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pocket>
 */
class PocketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement(['Kas Utama', 'Tabungan', 'Belanja Bulanan', 'Dana Darurat', 'Jajan & Kopi']),
            'initial_balance' => fake()->numberBetween(100000, 5000000),
            'current_balance' => fake()->numberBetween(100000, 5000000),
            'color' => fake()->randomElement(['zinc', 'emerald', 'blue', 'amber', 'rose']),
            'icon' => 'fa-wallet',
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
