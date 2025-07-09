<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventOccurrence>
 */
class EventOccurrenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => \App\Models\Event::factory(),
            'occurrence_date' => $this->faker->date(),
            'start_time' => $this->faker->optional()->Time(),
            'end_time' => $this->faker->optional()->Time(),
            'status' => $this->faker->randomElement(['pending', 'ongoing', 'ended', 'cancelled']),
            'attendance_checked' => $this->faker->boolean(),
        ];
    }
}
