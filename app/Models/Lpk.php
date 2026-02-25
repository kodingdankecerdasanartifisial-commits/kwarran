<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lpk extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'hero_image',
        'vision',
        'mission',
        'whatsapp',
        'email',
        'address',
        'social_media',
        'structure',
        'videos',
        'custom_html',
        'is_active',
    ];

    protected $casts = [
        'social_media' => 'array',
        'structure'    => 'array',
        'videos'       => 'array',
        'is_active'    => 'boolean',
    ];
}
