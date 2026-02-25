<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DigitalBannerController extends Controller
{
    public function index()
    {
        $banners = DigitalBanner::orderBy('order')->get();
        return view('admin.digital_banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.digital_banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                $path = storage_path('app/public/banners');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $data['image'] = $request->file('image')->store('banners', 'public');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar: ' . $e->getMessage());
            }
        }

        DigitalBanner::create($data);

        return redirect()->route('admin.digital-banners.index')->with('success', 'Spanduk digital berhasil ditambahkan.');
    }

    public function edit(DigitalBanner $digitalBanner)
    {
        return view('admin.digital_banners.edit', compact('digitalBanner'));
    }

    public function update(Request $request, DigitalBanner $digitalBanner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                if ($digitalBanner->image) {
                    Storage::disk('public')->delete($digitalBanner->image);
                }
                $data['image'] = $request->file('image')->store('banners', 'public');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar: ' . $e->getMessage());
            }
        }

        $digitalBanner->update($data);

        return redirect()->route('admin.digital-banners.index')->with('success', 'Spanduk digital berhasil diperbarui.');
    }

    public function destroy(DigitalBanner $digitalBanner)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus konten.');
        }

        if ($digitalBanner->image) {
            Storage::disk('public')->delete($digitalBanner->image);
        }
        $digitalBanner->delete();

        return redirect()->route('admin.digital-banners.index')->with('success', 'Spanduk digital berhasil dihapus.');
    }
}
