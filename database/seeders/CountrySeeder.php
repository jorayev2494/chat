<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use stdClass;

class CountrySeeder extends Seeder
{
    /**
     * @var Http $httpClient
     */
    private readonly Http $httpClient; 

    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        /** @var Response $onlineCountries */
        $onlineCountries = $this->httpClient::acceptJson()->get('https://restcountries.com/v3.1/all');

        foreach ($onlineCountries->json() as $country) {
            $countryData = [
                'name' => $country['name']['common'],
                'slug' => strtolower($country['name']['common']),
                'phone_code' => count($country['idd']) ? $country['idd']['root'] .  $country['idd']['suffixes'][0] : null,
                'flag' => $country['flag'],
                'flag_png' => $country['flags']['png'],
                'flag_svg' => $country['flags']['svg'],
            ];

            Country::create($countryData);
        }
    }
}
