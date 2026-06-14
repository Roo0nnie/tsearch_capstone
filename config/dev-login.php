<?php

use App\Models\Admin;
use App\Models\Faculty;
use App\Models\GuestAccount;
use App\Models\SuperAdmin;
use App\Models\User;

return [
    'roles' => [
        'student' => [
            'model' => User::class,
            'guard' => 'user',
            'email' => 'ssu.student@test.local',
            'redirect' => 'home',
            'status_field' => 'status',
            'status_value' => 'online',
        ],
        'faculty' => [
            'model' => Faculty::class,
            'guard' => 'faculty',
            'email' => 'faculty@test.local',
            'redirect' => 'faculty.home',
            'status_field' => 'status',
            'status_value' => 'online',
        ],
        'guest' => [
            'model' => GuestAccount::class,
            'guard' => 'guest_account',
            'email' => 'guest@test.local',
            'redirect' => 'guest.account.home',
            'status_field' => 'status',
            'status_value' => 'Active',
        ],
        'admin' => [
            'model' => Admin::class,
            'guard' => 'admin',
            'email' => 'admin@test.local',
            'redirect' => 'admin.dashboard',
            'status_field' => 'status',
            'status_value' => 'active',
        ],
        'superadmin' => [
            'model' => SuperAdmin::class,
            'guard' => 'superadmin',
            'email' => 'superadmin@test.local',
            'redirect' => 'superadmin.super_dashboard',
        ],
    ],
];
