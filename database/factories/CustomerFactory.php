<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $meterNumber = $this->faker->unique()->numberBetween(100000000000, 999999999999);

        return [
            'meter_number' => $meterNumber,
            'address' => $this->faker->address(),
            'initial_meter' => $this->faker->numberBetween(100, 400),
            'is_blocked' => 0,
            'block_reason' => null,
            'tarif_id' => $this->faker->numberBetween(1, 5), // Assuming you have 5 different tariffs
            'user_id' => User::factory()->state([
                'role_id' => 3,
                'password' => bcrypt($meterNumber),
            ])
        ];
    }
}
