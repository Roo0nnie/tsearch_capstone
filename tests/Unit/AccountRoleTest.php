<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Faculty;
use App\Models\GuestAccount;
use App\Models\SuperAdmin;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class AccountRoleTest extends TestCase
{
    public function test_legacy_auth_models_expose_normalized_roles(): void
    {
        $this->assertSame('student', (new User(['type' => 'student']))->accountRoleName());
        $this->assertSame('faculty', (new Faculty(['type' => 'faculty']))->accountRoleName());
        $this->assertSame('admin', (new Admin(['type' => 'admin']))->accountRoleName());
        $this->assertSame('guest', (new GuestAccount(['type' => 'user']))->accountRoleName());
        $this->assertSame('superadmin', (new SuperAdmin())->accountRoleName());
    }

    public function test_legacy_models_can_check_roles(): void
    {
        $this->assertTrue((new User(['type' => 'student']))->hasRole('student'));
        $this->assertTrue((new GuestAccount(['type' => 'guest']))->hasRole(['guest', 'student']));
        $this->assertFalse((new Admin(['type' => 'admin']))->hasRole('student'));
    }
}
