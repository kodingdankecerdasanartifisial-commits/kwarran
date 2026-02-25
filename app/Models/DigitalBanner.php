<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DigitalBanner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'link',
        'is_active',
        'order',
    ];
}
