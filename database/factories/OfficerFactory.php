<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
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
        // Ensure we have a valid role_id
        $roleId = Role::inRandomOrder()->first()?->id;
        if (!$roleId) {
            $roleId = Role::factory()->create()->id;
        }

        // Ensure we have a valid user_id
        $userId = User::inRandomOrder()->first()?->id;
        if (!$userId) {
            $userId = User::factory()->create()->id;
        }

        return [
            'role_id' => $roleId,
            'user_id' => $userId,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
            'custom_role' => $this->faker->optional()->word(),
        ];
    }
}
