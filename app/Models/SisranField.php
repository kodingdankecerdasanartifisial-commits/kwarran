<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SisranField extends Model
{
    protected $fillable = ['sisran_form_id', 'label', 'type', 'options', 'order', 'is_required'];

    public function form()
    {
        return $this->belongsTo(SisranForm::class, 'sisran_form_id');
    }
}
