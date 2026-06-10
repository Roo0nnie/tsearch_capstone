# T-Search — Thesis Management System

T-Search is a capstone web application for **Sorsogon State University (SSU)**. It catalogs thesis and research documents in **IMRAD** format and provides search, curation, reporting, and multi-role account management.

Built as a **Laravel 11 Blade monolith** with Vite, Tailwind CSS, and PostgreSQL.

## Features

- **IMRAD repository** — publish, draft, archive, and delete thesis documents with PDF upload and metadata extraction
- **Public guest browse** — search and filter theses without logging in
- **Google OAuth login** — SSU account sign-in for students and faculty (guest accounts)
- **Personal library** — save and manage favorite theses
- **Ratings and metrics** — rate theses; track views and downloads
- **Announcements** — role-targeted announcements from admins
- **Account management** — students, faculty, guests, and admins with Excel import/export
- **Reports** — SDG charts, file upload stats, user demographics; PDF and Excel exports
- **Audit and trash** — login history and soft-delete recovery
- **RBAC** — role-based access control (superadmin, admin, faculty, student, guest)

## System Requirements

| Component | Requirement |
|-----------|-------------|
| PHP | `^8.2` (8.2–8.4 recommended; see [Troubleshooting](#troubleshooting) for PHP 8.5) |
| Database | PostgreSQL 14+ |
| Composer | 2.x |
| Node.js | 18+ with npm |
| OS | Windows, Linux, or macOS |

### Required PHP Extensions

Enable these in your `php.ini`:

```
fileinfo
pdo_pgsql
pgsql
mbstring
openssl
curl
zip
gd
```

### Optional Integrations

| Integration | Purpose | Environment Variables |
|-------------|---------|----------------------|
| Google OAuth | SSU student/faculty login | `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` |
| SMTP mail | Admin/superadmin email verification | `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD` |
| Aspell | Search spell-check suggestions | System package (`tigitz/php-spellchecker`) |
| External PDF API | PDF metadata extraction | Used by `IMRADController` (remote service) |

## Project Structure

```mermaid
flowchart TB
    subgraph entry [EntryPoints]
        webPhp["routes/web.php"]
        publicRoutes["routes/web/public.php"]
        adminRoutes["routes/web/admin.php"]
        superRoutes["routes/web/superadmin.php"]
        guestRoutes["routes/web/guest-account.php"]
        studentRoutes["routes/web/student.php"]
    end
    subgraph app [Application]
        controllers["app/Http/Controllers"]
        models["app/Models"]
        middleware["app/Http/Middleware"]
        authServices["app/Services/Auth"]
    end
    subgraph data [Data]
        migrations["database/migrations"]
        seeders["database/seeders/RbacSeeder.php"]
        rbacConfig["config/rbac.php"]
    end
    subgraph ui [Frontend]
        views["resources/views"]
        vite["resources/js + Vite"]
    end
    webPhp --> publicRoutes & adminRoutes & superRoutes & guestRoutes & studentRoutes
    publicRoutes --> controllers
    controllers --> models
    controllers --> migrations
    controllers --> views
    views --> vite
```

### Key Directories

| Path | Description |
|------|-------------|
| `app/Http/Controllers/` | HTTP handlers (IMRAD, reports, accounts, auth) |
| `app/Models/` | Eloquent models (`Imrad`, `User`, `Admin`, `GuestAccount`, etc.) |
| `app/Http/Middleware/` | Auth, RBAC (`EnsureRole`, `EnsurePermission`), session middleware |
| `app/Services/Auth/` | `AccountResolver`, `AccountLookup` — multi-guard account resolution |
| `app/Exports/`, `app/Imports/` | Maatwebsite Excel import/export |
| `routes/web.php` | Loads audience-based route files |
| `routes/web/` | `public.php`, `admin.php`, `superadmin.php`, `guest-account.php`, `student.php` |
| `config/auth.php` | Multi-guard session auth |
| `config/rbac.php` | Role and permission definitions |
| `resources/views/` | Blade templates (`admin/`, `superadmin/`, `main_layouts/`, `components/ui/`) |
| `resources/js/`, `resources/css/` | Vite + Tailwind frontend assets |
| `database/migrations/` | Schema migrations (26 tables including RBAC) |
| `database/seeders/` | `RbacSeeder` — seeds roles and permissions |

## User Roles and Entry URLs

| Role | Login / Entry | Dashboard |
|------|---------------|-----------|
| Public guest | `/guest` | — |
| Guest (Google OAuth) | `/guest/auth/google` | `/guest/account/home` |
| Admin | `/login/admin` | `/admin/dashboard` |
| Super Admin | `/login/superadmin` | `/super_admin/dashboard` |
| Student (legacy) | `/home` (auth required) | `/home` |

**Landing page:** `/` (`landing.page`)

Auth uses multiple Laravel guards (`admin`, `superadmin`, `user`, `faculty`, `guest_account`) with an RBAC layer. See [docs/refactor-foundation.md](docs/refactor-foundation.md) for refactor details.

## Environment Setup

### 1. Clone and enter the project

```powershell
cd D:\projects\tsearch_capstone
```

```bash
cd /path/to/tsearch_capstone
```

### 2. Create environment file

**Windows (PowerShell):**

```powershell
copy .env.example .env
```

**Linux / macOS:**

```bash
cp .env.example .env
```

### 3. Configure database

Edit `.env` with your PostgreSQL credentials:

```env
DB_CONNECTION=pgsql
DB_URL="postgresql://postgres:password@localhost:5432/tsearch"
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=tsearch
DB_USERNAME=postgres
DB_PASSWORD=password
```

Create the database in PostgreSQL:

```sql
CREATE DATABASE tsearch;
```

### 4. Configure optional services

```env
APP_NAME="Thesis Management System"
APP_URL=http://127.0.0.1:8000

GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=465
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=ssl
```

> **Security:** `.env` is gitignored. Never commit real credentials to version control.

## Installation

Run all commands from the **project root** (`tsearch_capstone/`), not your home directory.

### Windows (PowerShell)

```powershell
cd D:\projects\tsearch_capstone

composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install
npm run build
```

### Linux / macOS

```bash
cd /path/to/tsearch_capstone

composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install
npm run build
```

If `composer install` fails on **PHP 8.5**, use:

```powershell
composer install --ignore-platform-req=php --ignore-platform-req=php-64bit
```

## Running the Application

### Development (recommended — two terminals)

**Terminal 1 — Laravel backend:**

```powershell
php artisan serve
```

**Terminal 2 — Vite dev server (live CSS/JS reload):**

```powershell
npm run dev
```

Open **http://127.0.0.1:8000** in your browser.

### Production build (single terminal)

If you already ran `npm run build`, only the backend is needed:

```powershell
php artisan serve
```

### LAN / network access

```powershell
php artisan serve --host=0.0.0.0 --port=8000
```

Update `APP_URL` in `.env` to match your machine's IP if needed.

## Useful Commands

| Command | Purpose |
|---------|---------|
| `php artisan migrate:status` | Check migration state |
| `php artisan config:clear` | Clear cached config |
| `php artisan db:seed` | Re-seed roles and permissions |
| `php artisan storage:link` | Link `public/storage` to `storage/app/public` |
| `npm run build` | Build frontend assets for production |
| `npm run dev` | Start Vite dev server with hot reload |
| `composer install` | Install PHP dependencies |
| `php artisan test` | Run PHPUnit tests |

Health check endpoint: **http://127.0.0.1:8000/up**

## Windows / Cursor IDE Notes

- PHP must be on your system `Path` (e.g. `C:\php-8.5.7`).
- If `php` or `composer` is not recognized in a Cursor terminal, **close and open a new terminal**, or restart Cursor.
- The project includes `.vscode/settings.json` which prepends PHP and Composer to the terminal `Path` automatically.
- Run `composer install` and `php artisan` from `D:\projects\tsearch_capstone`, not `C:\Users\<you>`.

## Troubleshooting

| Problem | Solution |
|---------|----------|
| `composer.json not found` | `cd` into the project root before running commands |
| `php` / `composer` not recognized | Add PHP to PATH, restart terminal, or use full path: `C:\php-8.5.7\php.exe artisan serve` |
| `composer install` fails on PHP 8.5 | Run with `--ignore-platform-req=php --ignore-platform-req=php-64bit` |
| Database connection refused | Ensure PostgreSQL is running on port 5432 and `tsearch` database exists |
| `vendor/autoload.php` missing | Run `composer install` |
| Blank page or missing styles | Run `npm install` then `npm run build` |
| No login accounts | No default admin is seeded; create accounts via superadmin or database |
| Admin 2FA email not received | Configure SMTP settings in `.env` (`MAIL_*` variables) |

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 11, PHP 8.2+ |
| Database | PostgreSQL |
| Frontend | Blade, Vite 5, Tailwind CSS, SweetAlert2 |
| Auth | Multi-guard sessions, Google OAuth (Socialite), RBAC |
| PDF | DomPDF, smalot/pdfparser |
| Excel | Maatwebsite Excel |
| Images | Intervention Image |

## Related Documentation

- [docs/refactor-foundation.md](docs/refactor-foundation.md) — RBAC refactor, route splitting, and auth architecture notes

## Project Credits

**August – November 2024**

- Ronnie F. Estillero — Backend (Laravel)
- Marlon Orpiada — Frontend (Laravel)

## License

This project is built on the [Laravel](https://laravel.com) framework, which is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
