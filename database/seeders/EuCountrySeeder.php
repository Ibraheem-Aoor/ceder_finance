<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class EuCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $euCountries = $this->getDataToSeed();
        foreach($euCountries as $country)
        {
            Country::create([
                "name" => $country
            ]);
        }
    }



    protected function getDataToSeed(): array
    {
        return [
            "Austria",
            "Belgium",
            "Bulgaria",
            "Croatia",
            "Cyprus",
            "Czech Republic",
            "Denmark",
            "Estonia",
            "Finland",
            "France",
            "Germany",
            "Greece",
            "Hungary",
            "Ireland",
            "Italy",
            "Latvia",
            "Lithuania",
            "Luxembourg",
            "Malta",
            "Netherlands",
            "Poland",
            "Portugal",
            "Romania",
            "Slovakia",
            "Slovenia",
            "Spain",
            "Sweden"
        ];
    }

}
