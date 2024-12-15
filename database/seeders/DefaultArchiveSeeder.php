<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ArchiveDate;
use Carbon\Carbon;


class DefaultArchiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ArchiveDate::create([
            'archive_date' => 5,
        ]);
    }
}
