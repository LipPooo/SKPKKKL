<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@skpkkkl.com',
            'employee_id' => 'ADMIN001',
            'ic_number' => '000000000001',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_approved' => true
        ]);

        User::create([
            'name' => 'Boss Pengarah',
            'email' => 'boss@skpkkkl.com',
            'employee_id' => 'BOSS001',
            'ic_number' => '000000000002',
            'password' => Hash::make('password'),
            'role' => 'boss',
            'is_approved' => true
        ]);

        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Ahli ' . $i,
                'email' => 'ahli' . $i . '@skpkkkl.com',
                'employee_id' => 'MEMBER00' . $i,
                'ic_number' => '90010114000' . $i,
                'password' => Hash::make('password'),
                'role' => 'member',
                'is_approved' => true
            ]);
        }
    }
}
