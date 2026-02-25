<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'embed_link',
        'cover_image',
        'order',
        'is_active',
    ];
}
