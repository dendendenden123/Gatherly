<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role' => $this->faker->randomElement(['Minister', 'Finance', 'SCAN', 'Deacon', 'Kalihim', 'Choir', 'None']),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => $this->faker->optional()->phoneNumber(),
            'address' => $this->faker->address(),
            'birthdate' => $this->faker->date(),
            'sex' => $this->faker->randomElement(['male', 'female']),
            'baptism_date' => $this->faker->optional()->date(),
            'marital_status' => $this->faker->randomElement([
                'single',
                'married',
                'divorced',
                'separated',
                'widowed',
                'engaged',
                'civil union',
                'domestic partnership',
                'annulled',
            ]),
            'profile_image' => 'https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg',
            'document_image' => $this->faker->optional()->imageUrl(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'partially-active', 'expelled']),
            'is_Verify' => false,
            'email_verified' => false,
            'last_login_at' => $this->faker->dateTime(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
