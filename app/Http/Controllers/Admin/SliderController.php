<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                // Ensure directory exists and is writable
                $path = storage_path('app/public/sliders');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                
                if (!is_writable($path)) {
                    return redirect()->back()->withInput()->with('error', 'Folder penyimpanan tidak dapat ditulis. Silakan cek izin folder: ' . $path);
                }

                $data['image'] = $request->file('image')->store('sliders', 'public');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar: ' . $e->getMessage());
            }
        }

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil ditambahkan.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                // Ensure directory exists and is writable
                $path = storage_path('app/public/sliders');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                if (!is_writable($path)) {
                    return redirect()->back()->withInput()->with('error', 'Folder penyimpanan tidak dapat ditulis. Silakan cek izin folder: ' . $path);
                }

                if ($slider->image) {
                    Storage::disk('public')->delete($slider->image);
                }
                $data['image'] = $request->file('image')->store('sliders', 'public');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar: ' . $e->getMessage());
            }
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(Slider $slider)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus konten.');
        }

        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slide berhasil dihapus.');
    }
}
