<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = \App\Models\Document::latest()->paginate(10);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        $filePath = $request->file('file')->store('documents', 'public');

        \App\Models\Document::create([
            'title' => $request->title,
            'file_path' => $filePath,
            'is_published' => $request->has('is_published')
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diupload.');
    }

    public function edit(\App\Models\Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, \App\Models\Document $document)
    {
        $request->validate([
            'title' => 'required|max:255',
            'file' => 'nullable|mimes:pdf|max:10240',
        ]);

        $data = [
            'title' => $request->title,
            'is_published' => $request->has('is_published')
        ];

        if ($request->hasFile('file')) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($document->file_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($document->file_path);
            }
            $data['file_path'] = $request->file('file')->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(\App\Models\Document $document)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus dokumen.');
        }

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($document->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    public function publicIndex()
    {
        $documents = \App\Models\Document::where('is_published', true)->orderBy('created_at', 'desc')->get();
        return view('pages.documents_index', compact('documents'));
    }

    public function publicShow($slug)
    {
        $document = \App\Models\Document::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('pages.document_viewer', compact('document'));
    }
}
