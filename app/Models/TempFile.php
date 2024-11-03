<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempFile extends Model
{
    use HasFactory;

    protected $table = 'temp_files';

    protected $fillable = [
        'department',
        'author',
        'adviser',
        'title',
        'abstract',
        'keywords',
        'awards',
        'publication_date',
        'publisher',
        'location',
        'volume',
        'issue',
        'SDG',
        'pdf_file',
    ];
}
