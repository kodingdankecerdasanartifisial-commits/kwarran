<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KtaKwarran;

class ValidasiController extends Controller
{
    public function kta($id)
    {
        $kta = KtaKwarran::findOrFail($id);
        return view('validasi.kta', compact('kta'));
    }
}
