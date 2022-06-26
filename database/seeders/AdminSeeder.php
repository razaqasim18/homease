<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '03351840056',
            'password' => Hash::make('admin'),
        ]);
    }
}