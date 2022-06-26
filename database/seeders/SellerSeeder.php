<?php

namespace Database\Seeders;

use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expireDate = date("Y-m-d", strtotime(date("Y-m-d") . "+1 month"));
        Seller::create([
            'name' => "seller",
            'username' => "seller",
            'phone' => "090078601",
            'email' => "seller@seller.com",
            'password' => Hash::make("seller"),
            'address' => "H3CM+PQ9، ساطان آباد روڈ، Shadola Road Area, Gujurat, Gujrat, Punjab, Pakistan",
            'location' => "32.571843185794584,74.08441543579102",
            'isverified' => 1,
            'expired_at' => $expireDate,
        ]);
    }
}