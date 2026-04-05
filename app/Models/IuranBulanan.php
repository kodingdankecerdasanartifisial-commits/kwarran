<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IuranBulanan extends Model
{
    protected $fillable = [
        'nama_pelapor',
        'asal_pangkalan',
        'no_wa',
        'nominal',
        'bukti_setoran',
        'catatan',
        'status',
        'finance_id',
    ];
}
