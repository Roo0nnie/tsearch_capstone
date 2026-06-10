# Refactor Foundation

This pass keeps the application as a Laravel Blade monolith while introducing the structure needed for the larger unified-auth refactor.

## What Changed

- `routes/web.php` now loads audience-based route files from `routes/web/`.
- Existing route URLs and route names are preserved.
- Legacy guards remain in place, but protected route groups now also declare normalized role middleware.
- First-party RBAC tables are introduced through `2026_05_22_000001_create_roles_and_permissions_tables.php`.
- Auth models expose `accountRoleName()`, `hasRole()`, and `hasPermission()` through `HasAccountRole`.
- `AccountResolver` centralizes current-account detection across the existing guards.
- `AccountLookup` centralizes user-code prefix lookup until the final unified users-table migration is ready.

## Compatibility Notes

- Existing `users`, `admins`, `faculties`, `guest_account`, and `super_admins` tables are not destroyed or merged in this batch.
- The RBAC migration adds nullable `role_id` columns to the legacy auth tables and backfills them to the default roles.
- Permission checks fall back to `config/rbac.php`, so the app can still authorize correctly before route handlers eager-load role relationships.
- The next migration batch can backfill all account records into the canonical `users` auth table once data constraints and duplicate email/user-code behavior are reviewed.

## Next Safe Batch

- Move duplicated account CRUD validation into Form Request classes.
- Convert admin/superadmin/sidebar visibility to `@role` and `@permission`.
- Add feature tests around every role's dashboard and denied-access path.
- Start the canonical `users` table migration with a backup and duplicate-account report.
