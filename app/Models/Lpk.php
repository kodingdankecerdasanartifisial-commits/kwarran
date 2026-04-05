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

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            $localPath = public_path('storage/' . $this->logo);
            if (file_exists($localPath)) {
                return asset('storage/' . $this->logo);
            }
            return 'https://kwarranbekasitimur.id/storage/' . $this->logo;
        }
        return asset('logo.png');
    }

    public function getHeroImageUrlAttribute()
    {
        if ($this->hero_image) {
            $localPath = public_path('storage/' . $this->hero_image);
            if (file_exists($localPath)) {
                return asset('storage/' . $this->hero_image);
            }
            return 'https://kwarranbekasitimur.id/storage/' . $this->hero_image;
        }
        return 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?q=80&w=1920&auto=format&fit=crop';
    }

    public static function getMemberPhotoUrl($photo)
    {
        if ($photo) {
            $localPath = public_path('storage/' . $photo);
            if (file_exists($localPath)) {
                return asset('storage/' . $photo);
            }
            return 'https://kwarranbekasitimur.id/storage/' . $photo;
        }
        return null;
    }
}
