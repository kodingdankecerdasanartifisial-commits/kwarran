<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SisranEntry extends Model
{
    protected $fillable = ['sisran_form_id', 'values', 'operator_name', 'operator_unit'];

    protected $casts = [
        'values' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(SisranForm::class, 'sisran_form_id');
    }
}
