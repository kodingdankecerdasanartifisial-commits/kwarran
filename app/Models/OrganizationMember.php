<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    protected $fillable = ['name', 'position', 'photo', 'sort_order'];

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            $localPath = public_path('storage/' . $this->photo);
            if (file_exists($localPath)) {
                return asset('storage/' . $this->photo);
            }
            return 'https://kwarranbekasitimur.id/storage/' . $this->photo;
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&color=fff&size=512';
    }
}
