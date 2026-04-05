<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KtaKwarran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KtaKwarranController extends Controller
{
    public function index()
    {
        $ktas = KtaKwarran::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.kta_kwarran.index', compact('ktas'));
    }

    public function create()
    {
        return view('admin.kta_kwarran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_tanggal_lahir' => 'required|string|max:255',
            'pangkalan' => 'required|string|max:255',
            'nomor_gudep' => 'nullable|string|max:255',
            'agama' => 'required|string|max:100',
            'golongan_darah' => 'required|string|max:10',
            'jabatan_golongan' => 'required|string|max:255',
            'kwarran' => 'required|string|max:255',
            'kwarcab' => 'required|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('pas_foto')) {
            $data['pas_foto'] = $request->file('pas_foto')->store('kta_fotos', 'public');
        }

        KtaKwarran::create($data);

        return redirect()->route('admin.kta_kwarran.index')
            ->with('success', 'Data KTA berhasil ditambahkan.');
    }

    public function edit(KtaKwarran $kta_kwarran)
    {
        return view('admin.kta_kwarran.edit', compact('kta_kwarran'));
    }

    public function update(Request $request, KtaKwarran $kta_kwarran)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_tanggal_lahir' => 'required|string|max:255',
            'pangkalan' => 'required|string|max:255',
            'nomor_gudep' => 'nullable|string|max:255',
            'agama' => 'required|string|max:100',
            'golongan_darah' => 'required|string|max:10',
            'jabatan_golongan' => 'required|string|max:255',
            'kwarran' => 'required|string|max:255',
            'kwarcab' => 'required|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'pas_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('pas_foto')) {
            if ($kta_kwarran->pas_foto) {
                Storage::disk('public')->delete($kta_kwarran->pas_foto);
            }
            $data['pas_foto'] = $request->file('pas_foto')->store('kta_fotos', 'public');
        }

        $kta_kwarran->update($data);

        return redirect()->route('admin.kta_kwarran.index')
            ->with('success', 'Data KTA berhasil diperbarui.');
    }

    public function destroy(KtaKwarran $kta_kwarran)
    {
        if ($kta_kwarran->pas_foto) {
            Storage::disk('public')->delete($kta_kwarran->pas_foto);
        }
        $kta_kwarran->delete();

        return redirect()->route('admin.kta_kwarran.index')
            ->with('success', 'Data KTA berhasil dihapus.');
    }

    public function print(KtaKwarran $kta_kwarran)
    {
        return view('admin.kta_kwarran.print', compact('kta_kwarran'));
    }
}
