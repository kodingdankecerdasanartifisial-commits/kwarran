<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'material_pdf',
        'youtube_url',
        'is_approved',
        'submitted_via',
        'submitter_name',
        'submitter_email',
        'category_id',
        'author',
        'published_at',
        'is_published',
        'is_html',
        'embed_code',
        'views',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'is_html' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->featured_image) {
            $localPath = public_path('storage/' . $this->featured_image);
            if (file_exists($localPath)) {
                return asset('storage/' . $this->featured_image);
            }
            return 'https://kwarranbekasitimur.id/storage/' . $this->featured_image;
        }

        if ($this->youtube_url) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->youtube_url, $matches);
            if (isset($matches[1])) {
                return "https://img.youtube.com/vi/{$matches[1]}/mqdefault.jpg";
            }
        }

        return null;
    }
}
