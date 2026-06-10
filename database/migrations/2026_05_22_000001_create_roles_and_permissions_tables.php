<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['role_id', 'permission_id']);
        });

        foreach (['users', 'admins', 'faculties', 'guest_account', 'super_admins'] as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'role_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
                });
            }
        }

        $this->seedDefaults();
    }

    public function down(): void
    {
        foreach (['users', 'admins', 'faculties', 'guest_account', 'super_admins'] as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'role_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropConstrainedForeignId('role_id');
                });
            }
        }

        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }

    private function seedDefaults(): void
    {
        $roles = [
            'superadmin' => ['label' => 'Super Admin', 'permissions' => ['*', 'accounts.admins.manage']],
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
        ];

        $now = now();
        $permissionLabels = [];

        foreach ($roles as $roleName => $definition) {
            DB::table('roles')->updateOrInsert(
                ['name' => $roleName],
                ['label' => $definition['label'], 'created_at' => $now, 'updated_at' => $now]
            );

            foreach ($definition['permissions'] as $permission) {
                $permissionLabels[$permission] = $permission === '*'
                    ? 'All permissions'
                    : str($permission)->replace('.', ' ')->title()->toString();
            }
        }

        foreach ($permissionLabels as $permission => $label) {
            DB::table('permissions')->updateOrInsert(
                ['key' => $permission],
                ['label' => $label, 'created_at' => $now, 'updated_at' => $now]
            );
        }

        $roleIds = DB::table('roles')->pluck('id', 'name');
        $permissionIds = DB::table('permissions')->pluck('id', 'key');

        foreach ($roles as $roleName => $definition) {
            foreach ($definition['permissions'] as $permission) {
                DB::table('role_permission')->updateOrInsert(
                    [
                        'role_id' => $roleIds[$roleName],
                        'permission_id' => $permissionIds[$permission],
                    ],
                    ['created_at' => $now, 'updated_at' => $now]
                );
            }
        }

        $legacyTables = [
            'users' => 'student',
            'admins' => 'admin',
            'faculties' => 'faculty',
            'guest_account' => 'guest',
            'super_admins' => 'superadmin',
        ];

        foreach ($legacyTables as $tableName => $roleName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'role_id') && isset($roleIds[$roleName])) {
                DB::table($tableName)->whereNull('role_id')->update(['role_id' => $roleIds[$roleName]]);
            }
        }
    }
};
