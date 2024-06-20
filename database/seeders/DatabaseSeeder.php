<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //   \App\Models\User::factory(10)->create();
        $this->call([
            PassengerSeeder::class,
            FlightSeeder::class,
            flightpassengerSeeder::class,
        ]);
        //  \App\Models\Passenger::factory(1000)->create();
        //\App\Models\Flight::factory(50)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
