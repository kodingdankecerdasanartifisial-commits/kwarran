<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['type', 'title', 'image', 'external_link', 'description', 'is_published'];
}
