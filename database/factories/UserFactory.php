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
      $lastNames =   [
    'Santos',
    'Reyes',
    'Cruz',
    'Bautista',
    'Dela Cruz',
    'Garcia',
    'Mendoza',
    'Torres',
    'Flores',
    'Villanueva',
    'Gonzales',
    'Ramos',
    'Aquino',
    'Castillo',
    'Rivera',
    'Morales',
    'Navarro',
    'Fernandez',
    'Dominguez',
    'Lopez',
    'Perez',
    'Hernandez',
    'Santiago',
    'Cabrera',
    'Castro',
    'Vargas',
    'Salazar',
    'Ortega',
    'Guzman',
    'Valdez',
    'Marquez',
    'Medina',
    'Aguilar',
    'Estrada',
    'Ocampo',
    'Panganiban',
    'Balagtas',
    'Vergara',
    'Soriano',
    'Lorenzo',
    'Evangelista',
    'Aguirre',
    'Francisco',
    'Rosales',
    'Padilla',
    'Sandoval',
    'Pascual',
    'Cortez',
    'Tolentino',
    'Abad',
    'Beltran',
    'Villamor',
    'Espino',
    'Manalo',
    'Cunanan',
    'Dizon',
    'Mercado',
    'Magtibay',
    'Basilio',
    'Laluz',
    'Salonga',
    'Basco',
    'Alcantara',
    'Arellano',
    'Bartolome',
    'Centeno',
    'Ferrer',
    'Lim',
    'Tan',
    'Cheng',
    'Chua',
    'Sy',
    'Dy',
    'Ong',
    'Go',
    'Co',
    'Lao',
    'Yu',
    'Lee',
    'Uy',
    'Que',
    'Tiu',
    'Jaucian',
    'Buenaventura',
    'Mabini',
    'Quiambao',
    'Malabanan',
    'De Guzman',
    'De Leon',
    'De Jesus',
    'De Vera',
    'Palma',
    'Rubio',
    'Carreon',
    'Legaspi',
    'Roxas',
];

$firstName =  $this->faker->firstName();
$lastName = $this->faker->randomElement($lastNames);
$email = $firstName . $lastName . Str::random(3) . '@gmail.com';




        return [
            'first_name' => $firstName,
            'last_name' =>$lastName,
            'middle_name' => $this->faker->randomElement($lastNames),
            'email' =>  $email,
            'password' => static::$password ??= Hash::make('password'),
            'phone' => $this->faker->optional()->phoneNumber(),
            'address' => $this->faker->address(),
            'birthdate' =>  $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'district' => 'carcar',
            'locale' => 'Locale ng Lutopan',
            'purok_grupo' => '1-5',
            'sex' => $this->faker->randomElement(['male', 'female']),
            'baptism_date' => $this->faker->dateTimeBetween('-40 years', '-18 years')->format('Y-m-d'),
            'marital_status' => $this->faker->randomElement([
                'single',
                'married',
                'separated',
                'widowed',
                'annulled',
            ]),
            'profile_image' => 'https://upload.wikimedia.org/wikipedia/commons/a/ac/Default_pfp.jpg',
            'document_image' => $this->faker->optional()->imageUrl(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'partially-active']),
            'is_Verify' => false,
            'email_verified' => false,
            'last_login_at' => $this->faker->dateTime(),
            'remember_token' => Str::random(10),
            'created_at' => $this->faker->dateTimeBetween('2025-01-01', '2025-12-30')->format('Y-m-d'),
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
