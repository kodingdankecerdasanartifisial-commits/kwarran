<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'transaction_date',
        'description',
        'details',
    ];
}
