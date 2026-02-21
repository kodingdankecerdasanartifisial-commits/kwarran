<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SisranForm extends Model
{
    protected $fillable = ['title', 'slug', 'category', 'description', 'is_active'];

    public function fields()
    {
        return $this->hasMany(SisranField::class)->orderBy('order');
    }

    public function entries()
    {
        return $this->hasMany(SisranEntry::class);
    }
}
