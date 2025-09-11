<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventOccurrence;
use App\Models\Officer;
use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles first
        Role::updateOrCreate(
            ['id' => 1],
            ['name' => 'Minister', 'description' => 'Head Minister of the Church']
        );
        Role::factory(9)->create();

        // Create users
        User::factory(10)->create();

        // Create officers (depends on roles and users)
        Officer::factory(5)->create();

        // Create events and related data
        Event::factory(5)->create();
        EventOccurrence::factory(5)->create();
        Attendance::factory(5)->create();
    }
}
