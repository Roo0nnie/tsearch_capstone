<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImradMetric extends Model
{
    use HasFactory;

    protected $table = 'imrad_metrics';

    protected $fillable = ['imradID', 'rates', 'clicks', 'downloads', 'saved', 'views'];

    public function ratings()
{
    return $this->hasMany(Rating::class, 'metric_id');
}

public function imrad()
    {
        return $this->belongsTo(Imrad::class, 'imradID');
    }

}


