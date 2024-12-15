<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Imrad;
use App\Models\ArchiveDate;
use Carbon\Carbon;


class AutoArchiveFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:auto-archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archives data that is older than a defined date into archive storage';

    /**
     * Execute the console command.
     */

     public function _construct() {
        parent::__construct();
     }

    public function handle()
    {
        \Log::info('AutoArchiveFile executed at: ' . now());
        $archive_year = ArchiveDate::first();

        $cutOffDate = Carbon::now()->subYear($archive_year);

        $ArchiveFile = Imrad::where('created_at', '<', $cutOffDate)->get();

        if($ArchiveFile->isEmpty()) {
            $this->info('No files to archive.');
            return;
        }

         foreach($ArchiveFile as $file) {
            $file->status = 'archive';
            $file->save();
        }

        $this->info('Files archived successfully.');
    }
}
