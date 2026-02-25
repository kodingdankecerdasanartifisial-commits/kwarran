<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        if (!in_array(auth()->user()->role, ['admin', 'lpk'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak.');
        }

        $finances = \App\Models\Finance::orderBy('transaction_date', 'desc')->paginate(15);
        
        $totalPemasukan = \App\Models\Finance::where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = \App\Models\Finance::where('type', 'pengeluaran')->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('admin.finances.index', compact('finances', 'totalPemasukan', 'totalPengeluaran', 'saldo'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['admin', 'lpk'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }
        return view('admin.finances.create');
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'lpk'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'type' => 'required|in:pemasukan,pengeluaran',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        \App\Models\Finance::create($validated);

        return redirect()->route('admin.lpk.finances.index')->with('success', 'Laporan keuangan berhasil ditambahkan.');
    }

    public function edit(\App\Models\Finance $finance)
    {
        if (!in_array(auth()->user()->role, ['admin', 'lpk'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }
        return view('admin.finances.edit', compact('finance'));
    }

    public function update(Request $request, \App\Models\Finance $finance)
    {
        if (!in_array(auth()->user()->role, ['admin', 'lpk'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'type' => 'required|in:pemasukan,pengeluaran',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        $finance->update($validated);

        return redirect()->route('admin.lpk.finances.index')->with('success', 'Laporan keuangan berhasil diperbarui.');
    }

    public function destroy(\App\Models\Finance $finance)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus laporan keuangan.');
        }

        $finance->delete();
        return redirect()->route('admin.lpk.finances.index')->with('success', 'Laporan keuangan berhasil dihapus.');
    }

    public function calendar()
    {
        if (!in_array(auth()->user()->role, ['admin', 'lpk'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak.');
        }

        $events = \App\Models\Finance::select('transaction_date', 'type', 'amount', 'description')
            ->get()
            ->map(function($item) {
                return [
                    'title' => ($item->type == 'pemasukan' ? '+' : '-') . ' Rp ' . number_format($item->amount),
                    'start' => $item->transaction_date,
                    'description' => $item->description,
                    'color' => $item->type == 'pemasukan' ? '#28a745' : '#dc3545'
                ];
            });

        return view('admin.finances.calendar', compact('events'));
    }

    public function publicIndex()
    {
        $finances = \App\Models\Finance::orderBy('transaction_date', 'desc')->get();
        
        $totalPemasukan = \App\Models\Finance::where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = \App\Models\Finance::where('type', 'pengeluaran')->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;
        
        $lastUpdate = \App\Models\Finance::latest('updated_at')->first();

        return view('pages.finances', compact('finances', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'lastUpdate'));
    }
}
