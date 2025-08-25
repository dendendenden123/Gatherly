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
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => $this->faker->optional()->phoneNumber(),
            'address' => $this->faker->address(),
            'birthdate' => $this->faker->date(),
            'district' => 'carcar',
            'locale' => $this->faker->randomElement([
                'Local ng Alcantara',
                'Local ng Argao',
                'Local ng Asturias',
                'Local ng Badian',
                'Local ng Balamban',
                'Local ng Barili',
                'Local ng Bato',
                'Local ng Binlod',
                'Local ng Bulasa',
                'Local ng Bulongan',
                'Local ng Cantao-an',
                'Local ng Carcar City',
                'Local ng Colon',
                'Local ng Dalaguete',
                'Local ng Don Juan Climaco Sr.',
                'Local ng Dumanjug',
                'Local ng Gen. Climaco',
                'Local ng Langtad',
                'Local ng Langub',
                'Local ng Lutopan',
                'Local ng Mainggit',
                'Local ng Malabuyoc',
                'Local ng Manguiao',
                'Local ng Mantalongon',
                'Local ng Naga',
                'Local ng Panadtaran',
                'Local ng Pinamungajan',
                'Local ng Ronda',
                'Local ng San Isidro',
                'Local ng Sangat',
                'Local ng Sibonga',
                'Local ng Sta Lucia',
                'Local ng Tag-Amakan',
                'Local ng Talaga',
                'Local ng Talavera',
                'Local ng Tiguib',
                'Local ng Toledo City',
            ]),
            'purok_grupo' => '1-5',
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
