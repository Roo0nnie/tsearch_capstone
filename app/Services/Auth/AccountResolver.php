<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AccountResolver
{
    public function guard(): ?string
    {
        foreach (config('rbac.guard_priority', []) as $guard) {
            if (Auth::guard($guard)->check()) {
                return $guard;
            }
        }

        return Auth::check() ? config('auth.defaults.guard') : null;
    }

    public function user(): ?Authenticatable
    {
        $guard = $this->guard();

        return $guard ? Auth::guard($guard)->user() : null;
    }

    public function roleName(?Authenticatable $user = null): ?string
    {
        $user ??= $this->user();

        if (!$user) {
            return null;
        }

        if (method_exists($user, 'accountRoleName')) {
            return $user->accountRoleName();
        }

        return strtolower((string) ($user->type ?? $this->guard()));
    }

    public function hasAnyRole(string|array $roles): bool
    {
        $roles = $this->normalize($roles);
        $user = $this->user();

        return $user && method_exists($user, 'hasRole') && $user->hasRole($roles);
    }

    public function hasPermission(string|array $permissions): bool
    {
        $permissions = $this->normalize($permissions);
        $user = $this->user();

        return $user && method_exists($user, 'hasPermission') && $user->hasPermission($permissions);
    }

    private function normalize(string|array $values): array
    {
        return collect(Arr::wrap($values))
            ->flatMap(fn ($value) => preg_split('/[|,]/', (string) $value) ?: [])
            ->map(fn ($value) => trim($value))
            ->filter()
            ->values()
            ->all();
    }
}
