<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $roleIds = [];

        foreach (config('rbac.roles', []) as $role => $definition) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role],
                ['label' => $definition['label'], 'created_at' => $now, 'updated_at' => $now]
            );

            $roleIds[$role] = DB::table('roles')->where('name', $role)->value('id');
        }

        foreach (config('rbac.roles', []) as $role => $definition) {
            foreach ($definition['permissions'] as $permission) {
                DB::table('permissions')->updateOrInsert(
                    ['key' => $permission],
                    [
                        'label' => $permission === '*' ? 'All permissions' : str($permission)->replace('.', ' ')->title()->toString(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                DB::table('role_permission')->updateOrInsert(
                    [
                        'role_id' => $roleIds[$role],
                        'permission_id' => DB::table('permissions')->where('key', $permission)->value('id'),
                    ],
                    ['created_at' => $now, 'updated_at' => $now]
                );
            }
        }
    }
}
