<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Menjalankan proses seeding untuk tabel users.
     */
    public function run(): void
    {
        // Membuat 3 pengguna dengan peran yang sudah ditentukan
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman
        ]);

        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@example.com',
            'role' => 'kasir',
            'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman
        ]);

        User::create([
            'name' => 'Dapur',
            'email' => 'dapur@example.com',
            'role' => 'dapur',
            'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman
        ]);
    }
}
