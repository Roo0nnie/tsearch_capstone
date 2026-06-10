<?php

namespace App\Services\Auth;

use App\Enums\AccountRole;
use App\Models\Admin;
use App\Models\Faculty;
use App\Models\GuestAccount;
use App\Models\User;

class AccountLookup
{
    public function findByCode(string $userCode)
    {
        $model = $this->modelForCode($userCode);

        return $model ? $model::where('user_code', $userCode)->first() : null;
    }

    public function modelForCode(string $userCode): ?string
    {
        return match (true) {
            str_starts_with($userCode, '21') => User::class,
            str_starts_with($userCode, '20') => Faculty::class,
            str_starts_with($userCode, '19') => Admin::class,
            str_starts_with($userCode, '09') => GuestAccount::class,
            default => null,
        };
    }

    public function roleForCode(string $userCode): ?AccountRole
    {
        return match (true) {
            str_starts_with($userCode, '21') => AccountRole::Student,
            str_starts_with($userCode, '20') => AccountRole::Faculty,
            str_starts_with($userCode, '19') => AccountRole::Admin,
            str_starts_with($userCode, '09') => AccountRole::Guest,
            default => null,
        };
    }

    public function profileDirectoryForCode(string $userCode): ?string
    {
        return match ($this->roleForCode($userCode)) {
            AccountRole::Student => public_path('assets/img/student_profile'),
            AccountRole::Faculty => public_path('assets/img/faculty_profile'),
            AccountRole::Admin => public_path('assets/img/admin_profile'),
            AccountRole::Guest => public_path('assets/img/guest_profile'),
            default => null,
        };
    }
}
