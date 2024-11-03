<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogHistory extends Model
{
    use HasFactory;
    protected $table = 'log_histories';
    protected $fillable = [
        'session_id',
        'user_code',
        'name',
        'user_type',
        'login',
        'logout',
    ];
}
