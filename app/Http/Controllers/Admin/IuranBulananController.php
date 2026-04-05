<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IuranBulanan;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IuranBulananController extends Controller
{
    public function index()
    {
        $iuran = IuranBulanan::latest()->paginate(10);
        return view('admin.iuran_bulanan.index', compact('iuran'));
    }

    public function create()
    {
        return view('admin.iuran_bulanan.create');
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

        return redirect()->route('admin.iuran_bulanan.index')
            ->with('success', 'Konfirmasi iuran berhasil dikirim. Menunggu verifikasi admin.');
    }

    public function show(IuranBulanan $iuranBulanan)
    {
        return view('admin.iuran_bulanan.show', compact('iuranBulanan'));
    }

    public function approve(IuranBulanan $iuranBulanan)
    {
        if ($iuranBulanan->status !== 'pending') {
            return back()->with('error', 'Data ini sudah diproses.');
        }

        // Create Finance record
        $finance = Finance::create([
            'type' => 'pemasukan',
            'amount' => $iuranBulanan->nominal,
            'transaction_date' => now(),
            'description' => 'Iuran Bulanan: ' . $iuranBulanan->asal_pangkalan . ' (' . $iuranBulanan->nama_pelapor . ')',
            'details' => $iuranBulanan->catatan,
        ]);

        $iuranBulanan->update([
            'status' => 'approved',
            'finance_id' => $finance->id
        ]);

        return redirect()->route('admin.iuran_bulanan.index')
            ->with('success', 'Iuran dikonfirmasi dan saldo kas telah diperbarui.');
    }

    public function reject(IuranBulanan $iuranBulanan)
    {
        if ($iuranBulanan->status !== 'pending') {
            return back()->with('error', 'Data ini sudah diproses.');
        }

        $iuranBulanan->update(['status' => 'rejected']);

        return redirect()->route('admin.iuran_bulanan.index')
            ->with('success', 'Iuran ditolak.');
    }

    public function destroy(IuranBulanan $iuranBulanan)
    {
        if ($iuranBulanan->bukti_setoran) {
            Storage::disk('public')->delete($iuranBulanan->bukti_setoran);
        }
        
        $iuranBulanan->delete();

        return redirect()->route('admin.iuran_bulanan.index')
            ->with('success', 'Data iuran berhasil dihapus.');
    }
}
