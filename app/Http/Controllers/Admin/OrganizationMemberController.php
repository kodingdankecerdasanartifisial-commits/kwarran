<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizationMemberController extends Controller
{
    public function index()
    {
        $members = \App\Models\OrganizationMember::orderBy('sort_order')->get();
        return view('admin.organization.index', compact('members'));
    }

    public function create()
    {
        return view('admin.organization.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'position' => 'required|max:255',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'integer',
        ]);

        $data = $request->only(['name', 'position', 'sort_order']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('organization', 'public');
        }

        \App\Models\OrganizationMember::create($data);

        return redirect()->route('admin.organization.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(\App\Models\OrganizationMember $organization)
    {
        return view('admin.organization.edit', ['member' => $organization]);
    }

    public function update(Request $request, \App\Models\OrganizationMember $organization)
    {
        $request->validate([
            'name' => 'required|max:255',
            'position' => 'required|max:255',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'integer',
        ]);

        $data = $request->only(['name', 'position', 'sort_order']);

        if ($request->hasFile('photo')) {
            if ($organization->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($organization->photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($organization->photo);
            }
            $data['photo'] = $request->file('photo')->store('organization', 'public');
        }

        $organization->update($data);

        return redirect()->route('admin.organization.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(\App\Models\OrganizationMember $organization)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus data.');
        }

        if ($organization->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($organization->photo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($organization->photo);
        }

        $organization->delete();

        return redirect()->route('admin.organization.index')->with('success', 'Data anggota berhasil dihapus.');
    }
}
