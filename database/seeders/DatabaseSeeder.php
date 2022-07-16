<?php

namespace Database\Seeders;

use App\Models\ChatStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(CountrySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ChatStatusSeeder::class);
        // $this->call(MessageSeeder::class);
    }
}
