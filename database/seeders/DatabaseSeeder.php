<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Event;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Generate Attendance
        Attendance::factory(5)->create();
        //Generate Events
        Event::factory(5)->create();
    }
}
