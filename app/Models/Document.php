<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['title', 'slug', 'file_path', 'is_published'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($document) {
            if (empty($document->slug)) {
                $document->slug = \Illuminate\Support\Str::slug($document->title);
            }
        });
    }
}
