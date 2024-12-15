<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedImrad extends Model
{
    use HasFactory;

    protected $table = 'deleted_imrads';
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
        'category',
        'awards',
        'SDG',
        'volume',
        'issue',
        'pdf_file',
        'deleted_time',
        'delete_by',
        'permanent_delete',
    ];
}
