<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dkr;
use App\Models\DkrAlbum;
use App\Models\DkrAlbumPhoto;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DkrAlbumController extends Controller
{
    public function index()
    {
        $dkr = Dkr::first();
        $albums = DkrAlbum::where('dkr_id', $dkr->id)->latest()->paginate(10);
        return view('admin.dkr.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.dkr.albums.create');
    }

    public function store(Request $request)
    {
        $dkr = Dkr::first();
        $request->validate([
            'name' => 'required|max:255',
            'cover_image' => 'nullable|image|max:5000',
            'photos.*' => 'nullable|image|max:10000',
            'bulk_photos.*' => 'nullable|image|max:10000',
        ]);

        $cover = null;
        if ($request->hasFile('cover_image')) {
            $cover = $this->compressImage($request->file('cover_image'), 'dkr/albums');
        }

        $album = DkrAlbum::create([
            'dkr_id' => $dkr->id,
            'name' => $request->name,
            'description' => $request->description,
            'cover_image' => $cover,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $file) {
                $path = $this->compressImage($file, 'dkr/albums/photos');
                DkrAlbumPhoto::create([
                    'dkr_album_id' => $album->id,
                    'image' => $path,
                    'caption' => $request->captions[$index] ?? '',
                ]);
            }
        }

        if ($request->hasFile('bulk_photos')) {
            foreach ($request->file('bulk_photos') as $file) {
                $path = $this->compressImage($file, 'dkr/albums/photos');
                DkrAlbumPhoto::create([
                    'dkr_album_id' => $album->id,
                    'image' => $path,
                    'caption' => '',
                ]);
            }
        }

        return redirect()->route('admin.dkr.albums.index')->with('success', 'Album berhasil dibuat.');
    }

    public function edit(DkrAlbum $album)
    {
        $album->load('photos');
        return view('admin.dkr.albums.edit', compact('album'));
    }

    public function update(Request $request, DkrAlbum $album)
    {
        $request->validate([
            'name' => 'required|max:255',
            'cover_image' => 'nullable|image|max:5000',
        ]);

        $album->name = $request->name;
        $album->description = $request->description;

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) Storage::disk('public')->delete($album->cover_image);
            $album->cover_image = $this->compressImage($request->file('cover_image'), 'dkr/albums');
        }
        $album->save();

        if ($request->hasFile('new_photos')) {
            foreach ($request->file('new_photos') as $index => $file) {
                $path = $this->compressImage($file, 'dkr/albums/photos');
                DkrAlbumPhoto::create([
                    'dkr_album_id' => $album->id,
                    'image' => $path,
                    'caption' => $request->new_captions[$index] ?? '',
                ]);
            }
        }

        if ($request->hasFile('bulk_photos')) {
            foreach ($request->file('bulk_photos') as $file) {
                $path = $this->compressImage($file, 'dkr/albums/photos');
                DkrAlbumPhoto::create([
                    'dkr_album_id' => $album->id,
                    'image' => $path,
                    'caption' => '',
                ]);
            }
        }

        if ($request->existing_photos) {
            foreach ($request->existing_photos as $photoId => $data) {
                $photo = DkrAlbumPhoto::find($photoId);
                if ($photo) {
                    $photo->caption = $data['caption'] ?? '';
                    $photo->save();
                }
            }
        }

        if ($request->delete_photos) {
            foreach ($request->delete_photos as $photoId) {
                $photo = DkrAlbumPhoto::find($photoId);
                if ($photo) {
                    Storage::disk('public')->delete($photo->image);
                    $photo->delete();
                }
            }
        }

        return redirect()->route('admin.dkr.albums.index')->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(DkrAlbum $album)
    {
        if ($album->cover_image) Storage::disk('public')->delete($album->cover_image);
        foreach ($album->photos as $photo) {
            Storage::disk('public')->delete($photo->image);
        }
        $album->delete();
        return redirect()->route('admin.dkr.albums.index')->with('success', 'Album berhasil dihapus.');
    }

    private function compressImage($file, $path, $quality = 60)
    {
        $imageInfo = @getimagesize($file);
        if (!$imageInfo) return $file->store($path, 'public');
        $mime = $imageInfo['mime'];
        
        try {
            switch ($mime) {
                case 'image/jpeg': $image = imagecreatefromjpeg($file); break;
                case 'image/png': $image = imagecreatefrompng($file); imagepalettetotruecolor($image); break;
                case 'image/webp': $image = imagecreatefromwebp($file); break;
                default: return $file->store($path, 'public');
            }

            $filename = Str::random(40) . '.webp';
            $savePath = $path . '/' . $filename;
            $fullPath = storage_path('app/public/' . $savePath);
            
            if (!file_exists(dirname($fullPath))) mkdir(dirname($fullPath), 0755, true);

            imagewebp($image, $fullPath, $quality);
            imagedestroy($image);
            return $savePath;
        } catch (\Exception $e) {
            return $file->store($path, 'public');
        }
    }
}
