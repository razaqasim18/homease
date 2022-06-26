<?php

namespace Database\Seeders;

use App\Models\Buyer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Buyer::create([
            'name' => 'buyer',
            'username' => 'buyer',
            'phone' => 'buyer',
            'email' => 'buyer@buyer.com',
            'password' => Hash::make('buyer'),
        ]);
    }
}