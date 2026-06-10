<?php

namespace App\Models\Concerns;

use App\Enums\AccountRole;
use App\Models\Admin;
use App\Models\Faculty;
use App\Models\GuestAccount;
use App\Models\Role;
use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Support\Arr;

trait HasAccountRole
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function accountRoleName(): string
    {
        if ($this->relationLoaded('role') && $this->role) {
            return $this->role->name;
        }

        if ($this->getAttribute('role_id') && $this->role) {
            return $this->role->name;
        }

        return match (true) {
            $this instanceof SuperAdmin => AccountRole::SuperAdmin->value,
            $this instanceof Admin => AccountRole::Admin->value,
            $this instanceof Faculty => AccountRole::Faculty->value,
            $this instanceof GuestAccount => AccountRole::Guest->value,
            $this instanceof User => AccountRole::fromLegacyType($this->getAttribute('type'))?->value ?? AccountRole::Student->value,
            default => AccountRole::fromLegacyType($this->getAttribute('type'))?->value ?? 'unknown',
        };
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = Arr::wrap($roles);

        return in_array($this->accountRoleName(), $roles, true);
    }

    public function hasPermission(string|array $permissions): bool
    {
        $permissions = Arr::wrap($permissions);

        if ($this->relationLoaded('role') && $this->role) {
            $rolePermissions = $this->role->permissions->pluck('key')->all();
            if (in_array('*', $rolePermissions, true) || array_intersect($permissions, $rolePermissions)) {
                return true;
            }
        }

        $configuredPermissions = config('rbac.roles.' . $this->accountRoleName() . '.permissions', []);

        return in_array('*', $configuredPermissions, true) || (bool) array_intersect($permissions, $configuredPermissions);
    }
}
