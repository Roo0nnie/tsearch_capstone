<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\LogHistory;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Admin;
use App\Models\GuestAccount;

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
    public function __construct() {
        parent::__construct();
        // $this->setHidden(true);
    }
    public function handle()
    {

         $timeout = 10;

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
        LogHistory::where('session_id', $sessionId)
        ->whereNull('logout')
        ->update(['logout' => now()]);

        $user_code = LogHistory::where('session_id', $sessionId)->value('user_code');

        $credentials = ['user_code' => $user_code];
        $guard = '';
        $model = '';

        if (str_starts_with($user_code, '21')) {
            $guard = 'user';
            $model = \App\Models\User::class;
        } elseif (str_starts_with($user_code, '20')) {
            $guard = 'faculty';
            $model = \App\Models\Faculty::class;
        } elseif (str_starts_with($user_code, '19')) {
            $guard = 'admin';
            $model = \App\Models\Admin::class;
        } elseif (str_starts_with($user_code, '09')) {
            $guard = 'guest_account';
            $model = \App\Models\GuestAccount::class;
        } else {
            return back()->withErrors(['user_code' => 'Invalid user ID format.'])->withInput();
        }

        $logHistoryCount = LogHistory::where('user_code', $user_code)
        ->whereNull('logout')->count();

        $user = $model::where('user_code', $user_code)->first();

        if ($logHistoryCount > 0) {

            $user->update(['status' => 'Active']);
        } else {

            $user->update(['status' => 'Inactive']);
        }

    }




}
