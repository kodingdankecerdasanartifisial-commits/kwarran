<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'chart_data', 'is_published'];

    protected $casts = [
        'chart_data' => 'array',
        'is_published' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($statistic) {
            if (empty($statistic->slug)) {
                $statistic->slug = \Illuminate\Support\Str::slug($statistic->title);
            }
        });
    }
}
