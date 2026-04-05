<?php

namespace App\Http\Controllers;

use App\Models\IuranBulanan;
use Illuminate\Http\Request;

class IuranPublicController extends Controller
{
    public function create()
    {
        return view('iuran.public_form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'asal_pangkalan' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'nominal' => 'required|numeric|min:0',
            'bukti_setoran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('bukti_setoran')) {
            $data['bukti_setoran'] = $request->file('bukti_setoran')->store('iuran_bukti', 'public');
        }

        IuranBulanan::create($data);

        return redirect()->back()->with('success', 'Konfirmasi iuran berhasil dikirim. Terima kasih, Kak! Menunggu verifikasi admin.');
    }
}
