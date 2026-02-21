<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'color',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];
}
