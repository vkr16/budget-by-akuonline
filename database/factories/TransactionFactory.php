<?php

namespace Database\Factories;

use App\Models\Pocket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
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
            'pocket_id' => Pocket::factory(),
            'type' => fake()->randomElement(['in', 'out']),
            'amount' => fake()->randomElement([15000, 25000, 50000, 100000, 250000, 500000]),
            'date' => fake()->dateTimeBetween('-1 month', 'now'),
            'description' => fake()->sentence(3),
        ];
    }
}
