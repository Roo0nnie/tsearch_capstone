<?php

namespace App\Enums;

enum AccountRole: string
{
    case SuperAdmin = 'superadmin';
    case Admin = 'admin';
    case Faculty = 'faculty';
    case Student = 'student';
    case Guest = 'guest';

    public function guard(): string
    {
        return match ($this) {
            self::SuperAdmin => 'superadmin',
            self::Admin => 'admin',
            self::Faculty => 'faculty',
            self::Student => 'user',
            self::Guest => 'guest_account',
        };
    }

    public static function fromLegacyType(?string $type): ?self
    {
        return match (strtolower((string) $type)) {
            'superadmin', 'super_admin' => self::SuperAdmin,
            'admin' => self::Admin,
            'faculty' => self::Faculty,
            'student', 'user' => self::Student,
            'guest', 'guest_account' => self::Guest,
            default => null,
        };
    }
}
