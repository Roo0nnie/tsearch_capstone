<?php

return [
    'guard_priority' => [
        'superadmin',
        'admin',
        'user',
        'faculty',
        'guest_account',
        'web',
    ],

    'roles' => [
        'superadmin' => [
            'label' => 'Super Admin',
            'permissions' => ['*', 'accounts.admins.manage'],
        ],
        'admin' => [
            'label' => 'Admin',
            'permissions' => [
                'accounts.students.manage',
                'accounts.faculty.manage',
                'accounts.guests.manage',
                'research.manage',
                'reports.view',
                'announcements.manage',
                'settings.manage',
                'trash.manage',
                'audit.view',
                'profile.manage',
            ],
        ],
        'faculty' => [
            'label' => 'Faculty',
            'permissions' => [
                'research.view',
                'research.save',
                'announcements.view',
                'preferences.manage',
                'ratings.manage',
                'profile.manage',
            ],
        ],
        'student' => [
            'label' => 'Student',
            'permissions' => [
                'research.view',
                'research.save',
                'announcements.view',
                'preferences.manage',
                'ratings.manage',
                'profile.manage',
            ],
        ],
        'guest' => [
            'label' => 'Guest',
            'permissions' => [
                'research.view',
                'research.save',
                'announcements.view',
                'preferences.manage',
                'ratings.manage',
                'profile.manage',
            ],
        ],
    ],
];
