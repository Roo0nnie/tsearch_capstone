<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\LogHistory;
use App\Models\Admin;
use App\Models\GuestAccount;
use Illuminate\Support\Facades\Auth;

class ClearInactiveSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:clear-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log out users and delete inactive sessions';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $timeout = 60;
        $cutoff = Carbon::now()->subMinutes($timeout)->timestamp;

        $sessions = DB::table('sessions')
            ->where('last_activity', '<', $cutoff)
            ->get();

        foreach ($sessions as $session) {
            $this->logLogout($session->id);

            DB::table('sessions')->where('id', $session->id)->delete();
        }

        $this->info('Inactive sessions cleared and users logged out successfully.');
    }

    protected function logLogout($sessionId)
    {
        $logHistory = LogHistory::where('session_id', $sessionId)
        ->whereNull('logout')
        ->first();

    if ($logHistory) {

        $logHistory->update(['logout' => now()]);

        $user_code = $logHistory->user_code;
        $guard = null;

        // Determine the user type and guard
        if (str_starts_with($user_code, '19')) {
            $guard = 'admin';
            $model = Admin::class;
        } elseif (str_starts_with($user_code, '09')) {
            $guard = 'guest_account';
            $model = GuestAccount::class;
        } else {
            $this->error("Invalid user_code format for session: {$sessionId}");
            return;
        }

        if ($guard) {
            Auth::guard($guard)->logout();

            session()->invalidate();
            session()->regenerateToken();
        }

        $user = $model::where('user_code', $user_code)->first();

        if ($user) {
            $activeLogins = LogHistory::where('user_code', $user_code)
                ->whereNull('logout')
                ->count();

            $status = $activeLogins > 0 ? 'Active' : 'Inactive';
            $user->update(['status' => $status]);

            $this->info("User with user_code {$user_code} set to {$status} and logged out.");
        } else {
            $this->error("User with user_code {$user_code} not found.");
        }
    }
    }
}
