<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Faculty;
use App\Models\GuestAccount;
use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    private const PASSWORD = 'password';

    private const BIRTHDAY = '2000-01-01';

    public function run(): void
    {
        $roleIds = DB::table('roles')->pluck('id', 'name');
        $password = Hash::make(self::PASSWORD);

        User::updateOrCreate(
            ['email' => 'ssu.student@test.local'],
            [
                'role_id' => $roleIds['student'],
                'name' => 'Demo Student',
                'user_code' => '210000001',
                'birthday' => self::BIRTHDAY,
                'password' => $password,
                'type' => 'student',
                'status' => 'offline',
                'account_status' => 'active',
            ]
        );

        Faculty::updateOrCreate(
            ['email' => 'faculty@test.local'],
            [
                'role_id' => $roleIds['faculty'],
                'name' => 'Demo Faculty',
                'user_code' => '200000001',
                'birthday' => self::BIRTHDAY,
                'password' => $password,
                'type' => 'faculty',
                'status' => 'offline',
            ]
        );

        GuestAccount::updateOrCreate(
            ['email' => 'guest@test.local'],
            [
                'role_id' => $roleIds['guest'],
                'name' => 'Demo Guest',
                'user_code' => '090000001',
                'birthday' => self::BIRTHDAY,
                'password' => $password,
                'type' => 'user',
                'status' => 'Active',
                'account_status' => 'active',
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'admin@test.local'],
            [
                'role_id' => $roleIds['admin'],
                'name' => 'Demo Admin',
                'user_code' => '190000001',
                'birthday' => self::BIRTHDAY,
                'password' => $password,
                'type' => 'admin',
                'status' => 'active',
                'account_status' => 'active',
                'verification_code' => null,
                'verification_code_expires_at' => null,
            ]
        );

        SuperAdmin::updateOrCreate(
            ['email' => 'superadmin@test.local'],
            [
                'role_id' => $roleIds['superadmin'],
                'name' => 'Demo Super Admin',
                'password' => $password,
                'verification_code' => null,
                'verification_code_expires_at' => null,
            ]
        );
    }
}
