<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Admin::create([
            'user_code' => '19000001',
            'name' => 'Ronnie Estillero',
            'email' => 'ronniewarrior09@gmail.com',
            'password' => Hash::make('admin123'),
            'phone' => '09100056780',
            'birthday' => '2024-10-16',
            'type' => 'admin',
            'status' => 'offline',
            'account_status' => 'active',
            'age' => 21,
            'gender' => 'male',
        ]);

        Admin::create([
            'user_code' => '19000002',
            'name' => 'Jona Cruz',
            'email' => 'jonacruz@example.com',
            'password' => Hash::make('admin123'),
            'phone' => '09123456789',
            'birthday' => '1990-04-12',
            'type' => 'admin',
            'status' => 'offline',
            'account_status' => 'active',
            'age' => 50,
            'gender' => 'female',
        ]);

        Admin::create([
            'user_code' => '19000003',
            'name' => 'Daniel Reyes',
            'email' => 'danielreyes@example.com',
            'password' => Hash::make('admin123'),
            'phone' => '09134567890',
            'birthday' => '1985-06-30',
            'type' => 'admin',
            'status' => 'offline',
            'account_status' => 'active',
        ]);

        Admin::create([
            'user_code' => '19000004',
            'name' => 'Mia Santos',
            'email' => 'miasantos@example.com',
            'password' => Hash::make('admin123'),
            'phone' => '09145678901',
            'birthday' => '1995-11-15',
            'type' => 'admin',
            'status' => 'offline',
            'account_status' => 'active',
            'age' => 34,
            'gender' => 'male',
        ]);

        Admin::create([
            'user_code' => '19000005',
            'name' => 'Sophia Lee',
            'email' => 'sophialee@example.com',
            'password' => Hash::make('admin123'),
            'phone' => '09156789012',
            'birthday' => '1992-01-25',
            'type' => 'admin',
            'status' => 'offline',
            'account_status' => 'active',
            'age' => 45,
            'gender' => 'female',
        ]);
    }
}
