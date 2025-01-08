<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyThesis extends Model
{
    use HasFactory;
    protected $table = 'my_thesis';

    protected $fillable = [
        'user_code',
        'user_type',
        'imrad_id',
    ];

    public function imrad()
    {
        return $this->belongsTo(Imrad::class, 'imrad_id', 'id');
    }
}
