<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DkrAlbumPhoto extends Model
{
    protected $fillable = ['dkr_album_id', 'image', 'caption'];

    public function album()
    {
        return $this->belongsTo(DkrAlbum::class, 'dkr_album_id');
    }
}
