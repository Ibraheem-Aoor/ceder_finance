<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nl_banks = $this->getDataToSeed();
        foreach($nl_banks as $bank)
        {
            Bank::query()->updateOrCreate([
                'name'  =>  $bank,
            ]);
        }
    }

    protected function getDataToSeed()
    {
        return [
            'ABN AMRO',
            'ING',
            'SNS Bank',
            'Triodos Bank',
            'Rabobank',
            'Revolut',
            'Van Lanschot',
            'Bank Mendes Gans',
            'RegioBank',
            'NIBC ',
            'ASN Bank',
            "Knab"
        ];
    }
}
