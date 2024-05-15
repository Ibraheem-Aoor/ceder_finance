<?php

namespace Database\Seeders;

use App\Models\ProductServiceCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = $this->getDataToSeed();
        User::query()->where('type' , 'company')->chunkById(10 , function($companies)use($categories){
            foreach($companies as $company){
                foreach($categories as $category){
                    $data = array_merge($category , ['created_by' => $company->id]);
                    ProductServiceCategory::query()->updateOrCreate($data);
                }
            }
        });
    }

    public function getDataToSeed(): array
    {
        return [
            ["name" => "Share capital", "type" => 1],
            ["name" => "Depreciation", "type" => 1],
            ["name" => "General/other costs", "type" => 1],
            ["name" => "Bank", "type" => 1],
            ["name" => "Bank charges", "type" => 1],
            ["name" => "VAT paid/received", "type" => 1],
            ["name" => "VAT paid/received for previous year", "type" => 1],
            ["name" => "Corporate tax paid (CIT)", "type" => 1],
            ["name" => "Payment and rounding differences", "type" => 1],
            ["name" => "Fines", "type" => 1],
            ["name" => "Deposit", "type" => 1],
            ["name" => "creditors", "type" => 1],
            ["name" => "Debtors", "type" => 1],
            ["name" => "Partially deductible costs", "type" => 1],
            ["name" => "Food and drinks in the catering industry", "type" => 1],
            ["name" => "Eating and drinking in the office", "type" => 1],
            ["name" => "Housing costs", "type" => 1],
            ["name" => "Purchasing costs of materials", "type" => 1],
            ["name" => "Investments", "type" => 1],
            ["name" => "Kas", "type" => 1],
            ["name" => "Cross-posting / Savings transaction", "type" => 1],
            ["name" => "Loans", "type" => 1],
            ["name" => "Revenue", "type" => 1],
            ["name" => "Education / training", "type" => 1],
            ["name" => "Old age reserve", "type" => 1],
            ["name" => "Profit transfer account", "type" => 1],
            ["name" => "Private deposits and withdrawals", "type" => 1],
            ["name" => "Promotional and advertising costs", "type" => 1],
            ["name" => "Travel expenses", "type" => 1],
            ["name" => "Current account", "type" => 1],
            ["name" => "Interest paid", "type" => 1],
            ["name" => "Receive interest", "type" => 1],
            ["name" => "Representation costs / Business gifts", "type" => 1],
            ["name" => "Software costs", "type" => 1],
            ["name" => "VAT to be paid", "type" => 1],
            ["name" => "VAT to be recovered", "type" => 1],
            ["name" => "Telephone costs / internet", "type" => 1],
            ["name" => "Corporate tax (corporate tax)", "type" => 1],
            ["name" => "Insurances", "type" => 1],
            ["name" => "stock", "type" => 1],
            ["name" => "Question items", "type" => 1],
            ["name" => "Profit reserves", "type" => 1]
        ];

    }
}
