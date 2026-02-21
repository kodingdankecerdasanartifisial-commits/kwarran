<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $downloads = Download::latest()->paginate(10);
        return view('admin.downloads.index', compact('downloads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.downloads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|max:51200',
            'external_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        if (!$request->hasFile('file_path') && !$request->filled('external_url')) {
            return back()->withErrors(['file_path' => 'Wajib upload file atau masukkan link eksternal.'])->withInput();
        }

        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('downloads', 'public');
            $validated['file_path'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        Download::create($validated);

        return redirect()->route('admin.downloads.index')->with('success', 'File berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Download $download)
    {
        return view('admin.downloads.edit', compact('download'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Download $download)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|max:51200',
            'external_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('file_path')) {
            // Delete old file
            if ($download->file_path && Storage::disk('public')->exists($download->file_path)) {
                Storage::disk('public')->delete($download->file_path);
            }
            
            $path = $request->file('file_path')->store('downloads', 'public');
            $validated['file_path'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $download->update($validated);

        return redirect()->route('admin.downloads.index')->with('success', 'Data download berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Download $download)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus konten.');
        }

        if ($download->file_path && Storage::disk('public')->exists($download->file_path)) {
            Storage::disk('public')->delete($download->file_path);
        }

        $download->delete();

        return redirect()->route('admin.downloads.index')->with('success', 'File berhasil dihapus.');
    }
}
