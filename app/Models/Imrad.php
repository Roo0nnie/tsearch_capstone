<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imrad extends Model
{
    use HasFactory;

    protected $table = 'imrads';

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
        'volume',
        'issue',
        'SDG',
        'pdf_file',
        'status',
        'deleted_time',
        'delete_by',
        'permanent_delete',
        'action',
    ];

    public function userable()
    {
        return $this->morphTo();
    }

    public function imradMetric()
    {
        return $this->hasOne(ImradMetric::class, 'imradID', 'id');
    }

    public function myLibraries()
    {
        return $this->hasMany(MyLibrary::class, 'imrad_id');
    }

    public function myTheses()
    {
        return $this->hasMany(MyThesis::class, 'imrad_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'metric_id');
    }
}
