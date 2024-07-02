<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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

        $superAdminRole = Role::create(['name' => 'super-admin']);

        $superAdminUser = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
        ]);
        $superAdminUser->assignRole($superAdminRole);


        //  \App\Models\Passenger::factory(1000)->create();
        //\App\Models\Flight::factory(50)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
