<?php

namespace Database\Seeders;

use App\Models\Maintenance;
use App\Models\MaintenanceItem;
use App\Models\Tool;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        User::firstOrCreate(['email' => 'ecep@example.com'], [
            'name' => 'Ecep Achmad Sutisna',
            'password' => bcrypt('Test@1234'),
            'email_verified_at' => Carbon::now(),
        ]);

        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate([
                'email' => 'user_' . $i . '@example.com',
            ], [
                'name' => "User $i",
                'password' => bcrypt('password')
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            Tool::create([
                'code' => 'tools-' . Str::random(10),
                'name' => $faker->randomElement(['Excavator', 'Bulldozer', 'Crane', 'Dump Truck'])
                    . " " . $faker->name(),
                'status' => $faker->randomElement(['active', 'repair', 'inactive']),
                'last_repair' => $faker->dateTimeBetween(Carbon::now()->subDay(30), Carbon::now()),
            ]);
        }

        $users = User::all();
        $tools = Tool::all();

        $requester = $users->random(rand(1, 3));
        $acceptance = $users->random(rand(1, 3));
        $selectedTools = $tools->random(rand(1, 3));
        $totalAmount = 0;

        $maintenance = Maintenance::create([
            'code' => 'INV-' . Str::upper(Str::random(8)),
            'requester_id' => $requester->id,
            'acceptance_id' => $acceptance->id,
            'total_amount' => $totalAmount,
            'start_date' => $faker->dateTimeBetween(Carbon::now()->subDay(30), Carbon::now()),
            'end_date' => $faker->dateTimeBetween(Carbon::now(), Carbon::now()->addDay(30)),
            'expired_at' => Carbon::now()->addHours(24)
        ]);

        foreach ($selectedTools as $tool) {
            $price = rand(500, 5000) * 1000;
            $totalOrderAmount += $price;
            MaintenanceItem::create([
                'maintenance_id' => $maintenance->id,
                'tool_id' => $tool->id,
                'tool_name' => $tool->name,
                'price' => $price
            ]);
        }
    }
}
