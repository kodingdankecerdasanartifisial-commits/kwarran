<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LpkAgenda extends Model
{
    protected $fillable = ['lpk_id', 'title', 'date', 'time', 'location', 'description', 'is_public'];

    protected $casts = [
        'date' => 'date',
        'is_public' => 'boolean',
    ];

    public function lpk()
    {
        return $this->belongsTo(Lpk::class);
    }
}
