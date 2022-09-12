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
        $seeders = [
            [OrderStatusesSeeder::class, false],
            [TestUserSeeder::class, true],
            [TestProductsSeeder::class, true]
        ];
        foreach ($seeders as $seed) {
            if ($seed[1]) {
                $this->call($seed[0]);
            }
        }
    }
}
