<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EventOccurrence;
use App\Models\User;

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
            // 'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),

            'user_id' => 6,
            "event_occurrence_id" => $this->faker->randomElement(EventOccurrence::pluck('id')->toArray()),
            'service_date' => $this->faker->dateTimeBetween('2025-09-01', '2025-9-30')->format('Y-m-d'),
            'check_in_time' => $this->faker->time(),
            'check_out_time' => $this->faker->optional()->time(),
            'attendance_method' => $this->faker->randomElement(['in-person', 'online', 'fingerprint', 'mobile']),
            'biometric_data_id' => $this->faker->optional()->uuid(),
            'recorded_by' => $this->faker->optional()->randomElement(User::pluck('id')->toArray()),
            'status' => $this->faker->randomElement(['present', 'absent']),
            'notes' => $this->faker->optional()->sentence(),
            'created_at' => $this->faker->dateTimeBetween('2025-09-01', '2025-9-30')->format('Y-m-d'),
            'updated_at' => $this->faker->dateTimeBetween('2025-09-01', '2025-9-30')->format('Y-m-d'),
        ];
    }
}
