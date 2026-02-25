<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dkr;
use App\Models\Post;
use App\Models\Category;
use App\Models\DkrAlbum;
use App\Models\DkrAlbumPhoto;
use App\Models\DkrAgenda;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DkrController extends Controller
{
    public function landingPage()
    {
        $dkr = Dkr::first();
        if (!$dkr) {
            $dkr = Dkr::create([
                'name' => 'DKR Bekasi Timur',
                'slug' => 'dkr-bekasi-timur',
                'is_active' => true,
            ]);
        }
        return view('admin.dkr.landingpage', compact('dkr'));
    }

    public function updateLandingPage(Request $request)
    {
        $dkr = Dkr::first();
        $validated = $request->validate([
            'name' => 'required|max:255',
            'logo' => 'nullable|image|max:2048',
            'hero_image' => 'nullable|image|max:2048',
            'vision' => 'nullable',
            'mission' => 'nullable',
            'active_members_count' => 'nullable|integer',
            'male_members_count' => 'nullable|integer',
            'female_members_count' => 'nullable|integer',
            'whatsapp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable',
            'social_media' => 'nullable|array',
            'routine_activities' => 'nullable|array',
            'structure' => 'nullable|array',
            'gallery' => 'nullable|array',
            'videos' => 'nullable|array',
            'achievements' => 'nullable|array',
            'custom_html' => 'nullable',
        ]);

        $validated['active_members_count'] = $validated['active_members_count'] ?? 0;
        $validated['male_members_count'] = $validated['male_members_count'] ?? 0;
        $validated['female_members_count'] = $validated['female_members_count'] ?? 0;

        // Handle images with compression
        if ($request->hasFile('logo')) {
            if ($dkr->logo) Storage::disk('public')->delete($dkr->logo);
            $validated['logo'] = $this->compressImage($request->file('logo'), 'dkr');
        }
        if ($request->hasFile('hero_image')) {
            if ($dkr->hero_image) Storage::disk('public')->delete($dkr->hero_image);
            $validated['hero_image'] = $this->compressImage($request->file('hero_image'), 'dkr');
        }

        // Handle Structure Photos
        $structure = $request->structure ?? [];
        if ($request->hasFile('structure_photos')) {
            foreach ($request->file('structure_photos') as $index => $photo) {
                if (isset($structure[$index])) {
                    if (!empty($structure[$index]['photo'])) {
                        Storage::disk('public')->delete($structure[$index]['photo']);
                    }
                    $structure[$index]['photo'] = $this->compressImage($photo, 'dkr/structure');
                }
            }
        }
        $validated['structure'] = $structure;
        
        // Removed gallery handling from here as it's moved to Albums table
        unset($validated['gallery']);

        $dkr->update($validated);

        return redirect()->back()->with('success', 'Landing Page DKR berhasil diperbarui.');
    }

    public function posts()
    {
        $category = Category::where('name', 'DKR')->first();
        $posts = Post::where('category_id', $category->id)->latest()->paginate(10);
        return view('admin.dkr.posts', compact('posts', 'category'));
    }

    // --- ALBUM MANAGEMENT ---
    // --- HELPER COMPRESSION ---
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
