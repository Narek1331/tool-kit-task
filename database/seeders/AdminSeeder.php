<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin_name',
            'phone_number' => '12345678',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'admin'
        ]);
    }
}
