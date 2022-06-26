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
        $this->call([
            AdminSeeder::class,
            SellerSeeder::class,
            BuyerSeeder::class,
            // CategorySeeder::class,
            // FaqSeeder::class,
        ]);

        \App\Models\Faq::factory(10)->create();
        \App\Models\Blog::factory(10)->create();
        \App\Models\Category::factory(10)->create();
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}