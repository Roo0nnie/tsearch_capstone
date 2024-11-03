<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'adviser',
        'department',
        'abstract',
        'publisher',
        'publication_date',
        'keywords',
        'location',
        'awards',
        'SDG',
        'volume',
        'issue',
        'pdf_file',
    ];
}
