<?php

namespace Database\Seeders;

use App\Client;
use App\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Provider::create([
            'name' => "General Supplies",
            'description' => "All purchases that have no specific provider or supplier",
            'email' => "",
            'phone' => "",
            'paymentinfo' => ""
        ]);

        // client

        // Client::create([
        //     'name' => 'General Client',
        // ]);
    }
}
