<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';
    protected $fillable = ['metric_id', 'user_code', 'rating'];

    public function imrad_metric() {
        return $this->belongsTo(ImradMetric::class, 'metric_id');
    }
}

