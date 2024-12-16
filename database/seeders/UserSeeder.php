<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin Kantin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin#123'), // Ubah ke password yang aman
            'role' => 'admin',
        ]);

        // Penjual
        $users = [
            ['name' => 'Mang Ijul', 'email' => 'mangijul@gokantin.com', 'role' => 'penjual'],
            ['name' => 'Mul', 'email' => 'mul@gokantin.com', 'role' => 'penjual'],
            ['name' => 'Bubur', 'email' => 'bubur@gokantin.com', 'role' => 'penjual'],
            ['name' => 'Roti Bakar', 'email' => 'rotibakar@gokantin.com', 'role' => 'penjual'],
            ['name' => 'Pecel', 'email' => 'pecel@gokantin.com', 'role' => 'penjual'],
            ['name' => 'Pakde', 'email' => 'pakde@gokantin.com', 'role' => 'penjual'],
            ['name' => 'Bude Gorengan', 'email' => 'bude@gokantin.com', 'role' => 'penjual'],
            ['name' => 'Ketoprak', 'email' => 'ketoprak@gokantin.com', 'role' => 'penjual'],
            ['name' => 'Kebab', 'email' => 'kebab@gokantin.com', 'role' => 'penjual'],
            ['name' => 'Rames', 'email' => 'rames@gokantin.com', 'role' => 'penjual'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'), // Password default
                'role' => $user['role'],
            ]);
        }
    }
}
