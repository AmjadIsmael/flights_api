<?php

namespace Database\Seeders;

use App\Models\Passenger;
use App\Models\Flight;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PassengerFlightTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passengers = Passenger::take(10)->get();
        $flights = Flight::take(10)->get();

        foreach ($passengers as $passenger) {
            $flightIds = $flights->random(mt_rand(2, 3))->pluck('id')->toArray();

            $passenger->flights()->attach($flightIds);
        }
    }
}
