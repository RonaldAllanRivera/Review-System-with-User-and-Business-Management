<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Allan',
            'last_name' => 'Rivera',
            'email' => 'allan@artworkwebsite.com',
            'password' => bcrypt('password'), // Known password
            'role' => 'admin',
            'email_verified_at' => now(), // Ensure email is verified
        ]);


        $this->call([
            UserSeeder::class,
            BusinessSeeder::class,
        ]);

    }
}
