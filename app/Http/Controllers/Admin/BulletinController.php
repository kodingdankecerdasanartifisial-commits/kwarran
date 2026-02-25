<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BulletinController extends Controller
{
    public function index()
    {
        $bulletins = Bulletin::orderBy('order')->get();
        return view('admin.bulletins.index', compact('bulletins'));
    }

    public function create()
    {
        return view('admin.bulletins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'embed_link' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer',
        ]);

        $data = $request->except('cover_image');
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('bulletins', 'public');
        }

        Bulletin::create($data);

        return redirect()->route('admin.bulletins.index')->with('success', 'Buletin berhasil ditambahkan.');
    }

    public function edit(Bulletin $bulletin)
    {
        return view('admin.bulletins.edit', compact('bulletin'));
    }

    public function update(Request $request, Bulletin $bulletin)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'embed_link' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer',
        ]);

        $data = $request->except('cover_image');
        if ($bulletin->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        }
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('cover_image')) {
            if ($bulletin->cover_image) {
                Storage::disk('public')->delete($bulletin->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('bulletins', 'public');
        }

        $bulletin->update($data);

        return redirect()->route('admin.bulletins.index')->with('success', 'Buletin berhasil diperbarui.');
    }

    public function destroy(Bulletin $bulletin)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus konten.');
        }

        if ($bulletin->cover_image) {
            Storage::disk('public')->delete($bulletin->cover_image);
        }
        $bulletin->delete();

        return redirect()->route('admin.bulletins.index')->with('success', 'Buletin berhasil dihapus.');
    }
}
