<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //User::factory()->count(15)->create();
        User::factory(10)->unverified()->create();
    }
}
