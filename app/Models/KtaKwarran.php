<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KtaKwarran extends Model
{
    protected $fillable = [
        'nta',
        'nama_lengkap',
        'tempat_tanggal_lahir',
        'pangkalan',
        'nomor_gudep',
        'agama',
        'golongan_darah',
        'jabatan_golongan',
        'kwarran',
        'kwarcab',
        'pas_foto',
        'alamat_lengkap',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->nta)) {
                $lastKta = self::where('nta', 'like', '09.25.01.%')
                               ->orderBy('id', 'desc')
                               ->first();
                
                $nextSequence = 1;
                
                if ($lastKta && $lastKta->nta) {
                    $parts = explode('.', $lastKta->nta);
                    if (count($parts) >= 4) {
                        $lastSequence = (int) end($parts);
                        $nextSequence = $lastSequence + 1;
                    }
                }
                
                $model->nta = '09.25.01.' . str_pad($nextSequence, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
