<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Admin;
use App\Models\Faculty;
use App\Models\GuestAccount;
use App\Models\Imrad;

use App\Observers\UserObserver;
use App\Observers\AdminObserver;
use App\Observers\FacultyObserver;
use App\Observers\GuestAccountObserver;
use App\Observers\ImradObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Admin::observe(AdminObserver::class);
        Faculty::observe(FacultyObserver::class);
        GuestAccount::observe(GuestAccountObserver::class);
        Imrad::observe(ImradObserver::class);
    }
}
