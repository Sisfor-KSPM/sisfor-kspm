<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // ==========================================
        // 1. Pembuatan 1 User Admin
        // ==========================================
        User::create([
            'name' => 'Administrator KSPM',
            'username' => 'admin',
            'email' => 'admin@kspm.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Password: password123
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        // ==========================================
        // 2. Pembuatan 2 User IPB
        // ==========================================
        for ($i = 1; $i <= 2; $i++) {
            $firstName = $faker->firstName;
            User::create([
                'name' => $firstName . ' ' . $faker->lastName,
                'username' => strtolower($firstName) . $faker->numberBetween(10, 99),
                'email' => 'user.ipb' . $i . '@ipb.ac.id', // Format email khusus mahasiswa IPB
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Password: password
                'role' => 'ipb',
                'remember_token' => Str::random(10),
            ]);
        }

        // ==========================================
        // 3. Pembuatan 5 User Umum
        // ==========================================
        for ($i = 1; $i <= 5; $i++) {
            $firstName = $faker->firstName;
            User::create([
                'name' => $firstName . ' ' . $faker->lastName,
                'username' => strtolower($firstName) . $faker->numberBetween(10, 99),
                'email' => 'user.umum' . $i . '@gmail.com', // Format email umum
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Password: password
                'role' => 'umum',
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
