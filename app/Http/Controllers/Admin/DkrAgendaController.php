<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dkr;
use App\Models\DkrAgenda;

class DkrAgendaController extends Controller
{
    public function index()
    {
        $dkr = Dkr::first();
        $agendas = DkrAgenda::where('dkr_id', $dkr->id)->orderBy('date', 'desc')->paginate(10);
        return view('admin.dkr.agendas.index', compact('agendas'));
    }

    public function store(Request $request)
    {
        $dkr = Dkr::first();
        $validated = $request->validate([
            'title' => 'required|max:255',
            'date' => 'required|date',
            'time' => 'nullable|max:100',
            'location' => 'nullable|max:255',
            'description' => 'nullable',
        ]);

        DkrAgenda::create(array_merge($validated, ['dkr_id' => $dkr->id]));

        return redirect()->back()->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function update(Request $request, DkrAgenda $agenda)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'date' => 'required|date',
            'time' => 'nullable|max:100',
            'location' => 'nullable|max:255',
            'description' => 'nullable',
        ]);

        $agenda->update($validated);

        return redirect()->back()->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(DkrAgenda $agenda)
    {
        $agenda->delete();
        return redirect()->back()->with('success', 'Agenda berhasil dihapus.');
    }
}
