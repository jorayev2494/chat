<?php

namespace Database\Seeders;

use App\Models\Country;
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
        $countries = Country::all('id');

        \App\Models\User::factory()->create([
            'email' => 'admin@gmail.com',
            'phone_country_id' => 63,
            'country_id' => 63,
        ]);

        \App\Models\User::factory()->create([
            'email' => 'admin2@gmail.com',
            'phone_country_id' => 63,
            'country_id' => 63,
        ]);

        for ($i=0; $i < 10; $i++) {
            $randomCountry = $countries->random(1);
            \App\Models\User::factory()->create([
                'phone_country_id' => $randomCountry->first(),
                'country_id' => $randomCountry->first(),
            ]);
        }
    }
}
