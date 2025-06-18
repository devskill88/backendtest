<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'name' => 'US Dollar',
                'symbol' => '$',
                'exchange_rate' => 1.0,
            ],
            [
                'name' => 'Euro',
                'symbol' => '€',
                'exchange_rate' => 0.85,
            ],
            [
                'name' => 'British Pound',
                'symbol' => '£',
                'exchange_rate' => 0.75,
            ],
            [
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'exchange_rate' => 110.0,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
