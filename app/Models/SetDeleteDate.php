<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetDeleteDate extends Model
{
    use HasFactory;

    protected $table = 'delete_date';

    protected $fillable = [
        'delete_date',
    ];
}
