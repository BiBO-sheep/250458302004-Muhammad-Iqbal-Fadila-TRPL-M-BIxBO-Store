<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk membuat akun awal.
     */
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => '0',
        ]);

        // Akun Seller
        User::create([
            'name' => 'Seller Toko',
            'email' => 'seller@gmail.com',
            'password' => Hash::make('seller123'),
            'role' => '1',
        ]);

        // Akun User
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123'),
            'role' => '2',
        ]);
    }
}
