<?php

namespace Database\Factories;

use \App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Officer>
 */
class OfficerFactory extends Factory
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
            // 'role' => $this->faker->randomElement([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]),
            'role' => '1'
        ];
    }
}
