<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SetDeleteDate;
use Carbon\Carbon;


class DefaultDeleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        SetDeleteDate::create([
            'delete_date' => 25,
        ]);
    }
}
