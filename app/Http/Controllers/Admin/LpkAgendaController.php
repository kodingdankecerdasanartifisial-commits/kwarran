<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpk;
use App\Models\LpkAgenda;
use Illuminate\Http\Request;

class LpkAgendaController extends Controller
{
    public function index()
    {
        $lpk = Lpk::first();
        $agendas = LpkAgenda::where('lpk_id', $lpk->id)->orderBy('date', 'desc')->paginate(10);
        return view('admin.lpk.agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.lpk.agendas.create');
    }

    public function store(Request $request)
    {
        $lpk = Lpk::first();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        $validated['lpk_id'] = $lpk->id;
        $validated['is_public'] = $request->has('is_public');

        LpkAgenda::create($validated);

        return redirect()->route('admin.lpk.agendas.index')->with('success', 'Agenda LPK berhasil ditambahkan.');
    }

    public function edit(LpkAgenda $agenda)
    {
        return view('admin.lpk.agendas.edit', compact('agenda'));
    }

    public function update(Request $request, LpkAgenda $agenda)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        $validated['is_public'] = $request->has('is_public');

        $agenda->update($validated);

        return redirect()->route('admin.lpk.agendas.index')->with('success', 'Agenda LPK berhasil diperbarui.');
    }

    public function destroy(LpkAgenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('admin.lpk.agendas.index')->with('success', 'Agenda LPK berhasil dihapus.');
    }
}
