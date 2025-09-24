<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\User;
use App\Models\Role;
use App\Models\Sermon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles using one whole array
        $roles = [
            [
                'id' => 1,
                'name' => 'Minister',
                'description' => 'Head Minister of the Church'
            ],
            [
                'id' => 3,
                'name' => 'Head Deacon',
                'description' => 'Leads the deacons in maintaining order and assisting the ministers'
            ],
            [
                'id' => 4,
                'name' => 'Deacon',
                'description' => 'Assists in church services, order, and member needs'
            ],
            [
                'id' => 5,
                'name' => 'Deaconess',
                'description' => 'Female counterpart of deacons, helps in church services and caring for brethren'
            ],
            [
                'id' => 6,
                'name' => 'Choir Leader',
                'description' => 'Leads the choir in worship services'
            ],
            [
                'id' => 7,
                'name' => 'Choir Member',
                'description' => 'Part of the choir, sings during worship services'
            ],
            [
                'id' => 9,
                'name' => 'Secretariat',
                'description' => 'Handles church records, reports, and documentation'
            ],
            [
                'id' => 10,
                'name' => 'KADIWA Officer',
                'description' => 'Youth officer (KADIWA organization for unmarried members 18+ years old)'
            ],
            [
                'id' => 11,
                'name' => 'Binhi Officer',
                'description' => 'Youth officer (BINHI organization for high school students)'
            ],
            [
                'id' => 12,
                'name' => 'Buklod Officer',
                'description' => 'Married members’ organization officer'
            ],
            [
                'id' => 13,
                'name' => 'Children’s Worship Service Teacher',
                'description' => 'Teaches children in the CWS worship services'
            ],
            [
                'id' => 15,
                'name' => 'Technical Support',
                'description' => 'Handles multimedia, sound system, and online broadcasts'
            ],
            [
                'id' => 16,
                'name' => 'SCAN',
                'description' => 'Serve as security personenl of the church'
            ],
            [
                'id' => 100,
                'name' => 'Member',
                'description' => 'Regular church member with no officer duties'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['id' => $role['id']],
                ['name' => $role['name'], 'description' => $role['description']]
            );
        }

        // Create users
        User::factory(5)->create();

        // Create events and related data
        Event::factory(3)->create();
        Attendance::factory(5)->create();
        Sermon::factory(5)->create();
    }
}
