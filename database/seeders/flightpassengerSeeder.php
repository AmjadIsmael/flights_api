<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Flight;
use App\Models\Passenger;


class flightpassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passengers = Passenger::take(1000)->get();
        $flights = Flight::take(50)->get();

        foreach ($passengers as $passenger) {
            $flightIds = $flights->random(mt_rand(2, 3))->pluck('id')->toArray();

            $passenger->flights()->attach($flightIds);
        }
    }
}
