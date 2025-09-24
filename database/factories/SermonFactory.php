<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sermon>
 */
class SermonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'preacher_id' => $this->faker->optional()->randomElement(User::pluck('id')->toArray()),
            'video_url' => $this->faker->url,
            'date_preached' => $this->faker->date(),
            'tags' => implode(',', $this->faker->words(3)),
        ];
    }
}
