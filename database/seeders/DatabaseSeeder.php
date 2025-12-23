<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(['email' => 'ecep@example.com'], [
            'name' => 'Ecep Achmad Sutisna',
            'password' => bcrypt('Test@1234'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
