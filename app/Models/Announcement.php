<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'adminId',
        'title',
        'content',
        'attachment',
        'start',
        'end',
        'distributed_to',
        'activation',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'adminId');
    }
}
