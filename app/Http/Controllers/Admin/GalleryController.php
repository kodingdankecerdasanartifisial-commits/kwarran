<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('created_at', 'desc')->paginate(12);
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:photo,video',
            'title' => 'required|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // For single cover
            'external_link' => 'nullable|string',
            'description' => 'nullable'
        ]);

        if ($request->type === 'photo') {
            if ($request->hasFile('images')) {
                // Bulk upload - each image is a record
                foreach ($request->file('images') as $image) {
                    $path = $this->compressAndStore($image);
                    Gallery::create([
                        'type' => 'photo',
                        'title' => $request->title,
                        'image' => $path,
                        'description' => $request->description,
                        'is_published' => true
                    ]);
                }
                return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil diunggah.');
            } elseif ($request->external_link) {
                // Link to Google Drive/Photos with optional cover
                $path = null;
                if ($request->hasFile('image')) {
                    $path = $this->compressAndStore($request->file('image'));
                }

                Gallery::create([
                    'type' => 'photo',
                    'title' => $request->title,
                    'image' => $path,
                    'external_link' => $request->external_link,
                    'description' => $request->description,
                    'is_published' => true
                ]);
                return redirect()->route('admin.gallery.index')->with('success', 'Link foto berhasil ditambahkan.');
            }
        } else {
            // Video
            Gallery::create([
                'type' => 'video',
                'title' => $request->title,
                'external_link' => $this->parseYoutubeId($request->external_link),
                'description' => $request->description,
                'is_published' => true
            ]);
            return redirect()->route('admin.gallery.index')->with('success', 'Video berhasil ditambahkan.');
        }

        return back()->with('error', 'Silakan unggah file atau masukkan link.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|max:5120',
            'external_link' => 'nullable|string',
            'description' => 'nullable'
        ]);

        $gallery->title = $request->title;
        $gallery->description = $request->description;

        if ($gallery->type === 'photo') {
            if ($request->hasFile('image')) {
                if ($gallery->image) Storage::disk('public')->delete($gallery->image);
                $gallery->image = $this->compressAndStore($request->file('image'));
            }
            $gallery->external_link = $request->external_link;
        } else {
            if ($request->filled('external_link')) {
                $gallery->external_link = $this->parseYoutubeId($request->external_link);
            }
        }

        $gallery->save();
        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang dapat menghapus galeri.');
        }

        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil dihapus.');
    }

    public function publicIndex()
    {
        $photos = Gallery::where('type', 'photo')
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('title'); // Grouping photos by title
            
        $videos = Gallery::where('type', 'video')
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('pages.gallery', compact('photos', 'videos'));
    }

    /**
     * Helper to compress image and return path
     */
    private function compressAndStore($file)
    {
        try {
            $filename = Str::random(20) . '.jpg';
            $path = 'gallery/' . $filename;
            
            // Ensure directory exists
            if (!Storage::disk('public')->exists('gallery')) {
                Storage::disk('public')->makeDirectory('gallery');
            }

            // Get actual file path
            $tempPath = $file->getRealPath();
            
            // Check if GD is available
            if (!extension_loaded('gd')) {
                return $file->store('gallery', 'public');
            }

            $imageInfo = getimagesize($tempPath);
            if (!$imageInfo) return $file->store('gallery', 'public');

            $mime = $imageInfo['mime'];

            switch ($mime) {
                case 'image/jpeg': $source = imagecreatefromjpeg($tempPath); break;
                case 'image/png': $source = imagecreatefrompng($tempPath); break;
                case 'image/webp': $source = imagecreatefromwebp($tempPath); break;
                default: return $file->store('gallery', 'public');
            }

            if (!$source) return $file->store('gallery', 'public');

            // Output to buffer
            ob_start();
            imagejpeg($source, null, 75); // 75% quality
            $compressedData = ob_get_clean();
            imagedestroy($source);

            Storage::disk('public')->put($path, $compressedData);
            
            return $path;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gallery Upload Error: ' . $e->getMessage());
            return $file->store('gallery', 'public'); // Final fallback
        }
    }

    private function parseYoutubeId($url)
    {
        if (strlen($url) <= 12) return $url;
        preg_match("/[\\?\\&]v=([^\\?\\&]+)/", $url, $matches);
        if ($matches) return $matches[1];
        preg_match("/(?:be\\/|embed\\/|v\\/|shorts\\/)([^\\/\\?]+)/", $url, $matches);
        return $matches ? $matches[1] : $url;
    }
}
