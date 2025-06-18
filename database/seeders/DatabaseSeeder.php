<?php

namespace Database\Seeders;

use App\Models\SBADistribution;
use App\Models\SocialMedia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            CurrencySeeder::class,
            ProductSeeder::class,
            ProductPriceSeeder::class,
        ]);
    }
}
