<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DkrAlbum extends Model
{
    protected $fillable = ['dkr_id', 'name', 'slug', 'cover_image', 'description'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($album) {
            if (empty($album->slug)) {
                $album->slug = Str::slug($album->name) . '-' . time();
            }
        });
    }

    public function dkr()
    {
        return $this->belongsTo(Dkr::class);
    }

    public function photos()
    {
        return $this->hasMany(DkrAlbumPhoto::class, 'dkr_album_id');
    }
}
