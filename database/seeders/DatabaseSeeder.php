<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PassengerSeeder::class,
            FlightSeeder::class,
            FlightPassengerSeeder::class,
        ]);

        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        Permission::create(['name' => 'edit-profile']);
        Permission::create(['name' => 'update-profile']);
        Permission::create(['name' => 'delete-profile']);
        Permission::create(['name' => 'view-profile']);

        // Assign permissions to roles
        $superAdminRole->givePermissionTo(['edit-profile', 'update-profile', 'delete-profile', 'view-profile']);

        // Create users and assign roles
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
