<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_name' => $this->faker->sentence(3),
            'event_description' => $this->faker->optional()->paragraph(),
            'event_type' => $this->faker->randomElement([
                'Weekend worship service',
                'weekdays worship service',
                'volunteer',
                'meeting',
                'evangelical'
            ]),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->optional()->time(),
            'location' => $this->faker->address(),
            'user_id' => \App\Models\User::factory(),
            'number_Volunteer_needed' => $this->faker->optional()->numberBetween(1, 50),
            'status' => $this->faker->randomElement(['upcoming', 'ongoing', 'completed', 'cancelled']),
            'reminder_sent' => $this->faker->boolean(),
        ];
    }
}
