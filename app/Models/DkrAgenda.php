<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DkrAgenda extends Model
{
    protected $fillable = ['dkr_id', 'title', 'date', 'time', 'location', 'description', 'is_public'];

    protected $casts = [
        'date' => 'date',
        'is_public' => 'boolean',
    ];

    public function dkr()
    {
        return $this->belongsTo(Dkr::class);
    }
}
