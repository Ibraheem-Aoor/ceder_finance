<?php

namespace Database\Seeders;

use App\Models\User;
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
            User::query()->where('type' , 'company')->chunkById(10 , function($companies)use($name , $value){
                foreach($companies as $company)
                {
                    // Clean to avoid duplicate entries
                    DB::table('settings')->where('name' , $name)->delete();
                    // Insert
                    DB::table('settings')->insert([
                        'name'   =>  $name,
                        'value' =>  $value,
                        'created_by' => $company->id,
                    ]);
                }
            });
        }
    }

    protected function getDataToSeed() : array
    {
        return [
            'btw_print_time'  => null,
            'payment_days' => null,
            'company_type' => null,
            'industry' => null,
            'bbc_invoice_email' => null,
            'emplyoee_number_prefix' => '#PERSO'
        ];
    }
}
