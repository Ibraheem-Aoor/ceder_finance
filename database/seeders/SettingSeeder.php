<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = $this->getDataToSeed();
        foreach($settings as $name => $value)
        {
            DB::table('settings')->insert([
                'name'   =>  $name,
                'value' =>  $value
            ]);
        }
    }

    protected function getDataToSeed() : array
    {
        return [
            'logo'  => null,
            'landing_logo'  => null,
            'favicon'  => null,
        ];
    }
}
