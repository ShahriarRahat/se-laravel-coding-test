<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
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
        $users = User::select('id')->get();

        return [
            "user_id" => $users->random()->id,
            "transaction_type" => $this->faker->randomElement(['deposit', 'withdrawal']),
            "amount" => $this->faker->randomFloat(2, 0, 1000),
            "fee" => 0,
            "date" => now()->toDateString(),
        ];
    }
}
