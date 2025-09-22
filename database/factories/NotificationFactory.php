<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recipient_group' => $this->faker->randomElement(['all', 'volunteers', 'buklod', 'kadiwa', 'binhi']),
            'sender_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'subject' => $this->faker->sentence(6),
            'message' => $this->faker->paragraph(),
            'category' => $this->faker->randomElement(['announcement', 'alert', 'reminder']),
            'is_read' => $this->faker->boolean(30), // 30% chance it's read
            'read_at' => $this->faker->optional()->dateTimeThisMonth(),
            'sent_at' => $this->faker->dateTimeThisMonth(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
