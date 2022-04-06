<?php

namespace Database\Seeders;

use App\Provider;
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
        $this->call([

            BranchSeeder::class,
            UserSeeder::class,
            ProviderSeeder::class
        ]);
    }
}
