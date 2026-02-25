<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dkr extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'hero_image',
        'vision',
        'mission',
        'active_members_count',
        'male_members_count',
        'female_members_count',
        'whatsapp',
        'email',
        'address',
        'social_media',
        'routine_activities',
        'structure',
        'gallery',
        'videos',
        'achievements',
        'custom_html',
        'is_active',
    ];

    protected $casts = [
        'social_media'       => 'array',
        'routine_activities' => 'array',
        'structure'          => 'array',
        'gallery'            => 'array',
        'videos'             => 'array',
        'achievements'       => 'array',
        'is_active'          => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
