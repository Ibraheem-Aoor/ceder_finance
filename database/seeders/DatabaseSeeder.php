<?php

namespace Database\Seeders;

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
        // $this->call(PlansTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $this->call(EuCountrySeeder::class);
        // $this->call(BankSeeder::class);
        $this->call(PermsissonSeeder::class);
        $this->call(SettingSeeder::class);

    }
}
