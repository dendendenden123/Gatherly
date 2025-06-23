<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'event_id' => \App\Models\Event::factory(),
            'service_date' => $this->faker->date(),
            'check_in_time' => $this->faker->time(),
            'check_out_time' => $this->faker->optional()->time(),
            'attendance_method' => $this->faker->randomElement(['in-person', 'online', 'fingerprint', 'mobile']),
            'biometric_data_id' => $this->faker->optional()->uuid(),
            'recorded_by' => $this->faker->optional()->randomElement(\App\Models\User::pluck('id')->toArray()),
            'status' => $this->faker->randomElement(['present', 'absent']),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
