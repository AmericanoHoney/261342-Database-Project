<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'fname' => 'Prae',
            'lname' => 'Thipwarin',
            'email' => 'prae@example.com',
            'password' => Hash::make('123456'),
            'photo' => 'https://blog.wu.ac.th/wp-content/uploads/2023/01/8.jpg',
            'phone' => '0812345678',
            'address' => 'Chiang Mai, Thailand',
            'bdate' => '2004-03-15',
        ]);
    }
}
