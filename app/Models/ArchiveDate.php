<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveDate extends Model
{
    use HasFactory;

    protected $table = 'archive_dates';

    protected $fillable = [
        'archive_date',
    ];
}
