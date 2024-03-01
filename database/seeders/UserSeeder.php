<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::create([
            'name' => 'admin',
                'email' => 'admin@gmail.com',
                'mobile_no' => '03015913636',
                'password' => Hash::make(12345678)
        ]);
    }
}
