<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'email' => 'admin@gmail.com'
        ]);

        \App\Models\User::factory()->create([
            'email' => 'admin2@gmail.com'
        ]);

        \App\Models\User::factory(10)->create();

        // Client ID: 1
        // Client secret: GtJOz71iEJnw1Vwt9ukozz2akllNtTu3pMOHvMQH
    }
}
