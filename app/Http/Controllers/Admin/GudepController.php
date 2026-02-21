<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Gudep;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GudepController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Operator Gudep can only see their own Gudep
        if ($user->role === 'operator_gudep') {
            $gudeps = Gudep::where('user_id', $user->id)->latest()->paginate(10);
        } else {
            $gudeps = Gudep::latest()->paginate(10);
        }

        return view('admin.gudep.index', compact('gudeps'));
    }

    public function create()
    {
        return view('admin.gudep.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pangkalan_name' => 'required|max:255',
            'gudep_number' => 'required|max:100',
            'logo' => 'nullable|image|max:2048',
            'hero_image' => 'nullable|image|max:2048',
            'vision' => 'nullable',
            'mission' => 'nullable',
            'active_members_count' => 'nullable|integer',
            'male_members_count' => 'nullable|integer',
            'female_members_count' => 'nullable|integer',
            'male_pembina_count' => 'nullable|integer',
            'female_pembina_count' => 'nullable|integer',
            'whatsapp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable',
            'social_media' => 'nullable|array',
            'routine_activities' => 'nullable|array',
            'structure' => 'nullable|array',
            'gallery' => 'nullable|array',
            'videos' => 'nullable|array',
            'achievements' => 'nullable|array',
            'potensi' => 'nullable|array',
            'potensi_pembina' => 'nullable|array',
        ]);

        $validated['active_members_count'] = $validated['active_members_count'] ?? 0;
        $validated['male_members_count'] = $validated['male_members_count'] ?? 0;
        $validated['female_members_count'] = $validated['female_members_count'] ?? 0;
        $validated['male_pembina_count'] = $validated['male_pembina_count'] ?? 0;
        $validated['female_pembina_count'] = $validated['female_pembina_count'] ?? 0;

        $validated['name'] = $request->pangkalan_name . ' (' . $request->gudep_number . ')';
        $validated['slug'] = Str::slug($request->pangkalan_name);
        
        // Handle unique slug
        $slugBase = $validated['slug'];
        $count = 1;
        while (Gudep::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $slugBase . '-' . (++$count);
        }
        
        // Handle images
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('gudep', 'public');
        }
        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $request->file('hero_image')->store('gudep', 'public');
        }

        // Handle Structure Photos
        if ($request->hasFile('structure_photos')) {
            $structure = $request->structure;
            foreach ($request->file('structure_photos') as $index => $photo) {
                if (isset($structure[$index])) {
                    $structure[$index]['photo'] = $photo->store('gudep/structure', 'public');
                }
            }
            $validated['structure'] = $structure;
        }

        // Handle Gallery Upload & Compression (Basic implementation using Laravel move/store)
        if ($request->hasFile('gallery_files')) {
            $gallery = $request->gallery ?? [];
            foreach ($request->file('gallery_files') as $index => $file) {
                // In a real environment with GD/Imagick, we'd compress here.
                // For now, we store them in a specific gallery folder.
                $path = $file->store('gudep/gallery', 'public');
                $gallery[] = [
                    'image_path' => $path,
                    'caption' => $request->gallery_captions[$index] ?? ''
                ];
            }
            $validated['gallery'] = $gallery;
        }

        // Handle Videos
        $validated['videos'] = $request->videos ?? [];

        // Handle Achievements
        $validated['achievements'] = $request->achievements ?? [];

        // Handle Potensi
        $potensi = $request->potensi ?? [];
        $potensi = array_filter($potensi, function($item) {
            return !empty($item['jenjang']) && !empty($item['jumlah']);
        });
        $validated['potensi'] = array_values($potensi);

        // Handle Potensi Pembina
        $potensi_pembina = $request->potensi_pembina ?? [];
        $processed = [];
        foreach ($potensi_pembina as $entry) {
            if (empty($entry['jenis_kelamin']) || empty($entry['jumlah'])) continue;
            
            $kursus_data = [];
            $belum_kursus = !empty($entry['belum_kursus']) ? 1 : 0;
            
            if (!$belum_kursus && !empty($entry['kursus'])) {
                foreach ($entry['kursus'] as $jenis => $data) {
                    if (!empty($data['active']) && !empty($data['tahun'])) {
                        $kursus_data[] = [
                            'jenis' => $jenis,
                            'tahun' => (int)$data['tahun']
                        ];
                    }
                }
            }
            
            if ($belum_kursus || !empty($kursus_data)) {
                $processed[] = [
                    'jenis_kelamin' => $entry['jenis_kelamin'],
                    'jumlah' => $entry['jumlah'],
                    'belum_kursus' => $belum_kursus,
                    'kursus_data' => $kursus_data
                ];
            }
        }
        $validated['potensi_pembina'] = $processed;

        // Set default social media if empty
        $social = $request->social_media ?? [];
        if (empty($social['facebook'])) $social['facebook'] = \App\Models\Setting::get('social_facebook');
        if (empty($social['instagram'])) $social['instagram'] = \App\Models\Setting::get('social_instagram');
        if (empty($social['youtube'])) $social['youtube'] = \App\Models\Setting::get('social_youtube');
        if (empty($social['tiktok'])) $social['tiktok'] = \App\Models\Setting::get('social_tiktok');
        $validated['social_media'] = $social;

        // Save with owner user_id
        $validated['user_id'] = auth()->id();

        Gudep::create($validated);

        return redirect()->route('admin.gudep.index')->with('success', 'Gudep berhasil ditambahkan.');
    }

    public function edit(Gudep $gudep)
    {
        $user = auth()->user();

        // Operator Gudep can ONLY edit their own Gudep
        if ($user->role === 'operator_gudep' && $gudep->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit data Gudep milik pangkalan lain.');
        }

        return view('admin.gudep.edit', compact('gudep'));
    }

    public function update(Request $request, Gudep $gudep)
    {
        $user = auth()->user();

        // Operator Gudep can ONLY update their own Gudep
        if ($user->role === 'operator_gudep' && $gudep->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah data Gudep milik pangkalan lain.');
        }
        $validated = $request->validate([
            'pangkalan_name' => 'required|max:255',
            'gudep_number' => 'required|max:100',
            'logo' => 'nullable|image|max:2048',
            'hero_image' => 'nullable|image|max:2048',
            'vision' => 'nullable',
            'mission' => 'nullable',
            'active_members_count' => 'nullable|integer',
            'male_members_count' => 'nullable|integer',
            'female_members_count' => 'nullable|integer',
            'male_pembina_count' => 'nullable|integer',
            'female_pembina_count' => 'nullable|integer',
            'whatsapp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable',
            'social_media' => 'nullable|array',
            'routine_activities' => 'nullable|array',
            'structure' => 'nullable|array',
            'gallery' => 'nullable|array',
            'videos' => 'nullable|array',
            'achievements' => 'nullable|array',
            'potensi' => 'nullable|array',
            'potensi_pembina' => 'nullable|array',
        ]);

        $validated['active_members_count'] = $validated['active_members_count'] ?? 0;
        $validated['male_members_count'] = $validated['male_members_count'] ?? 0;
        $validated['female_members_count'] = $validated['female_members_count'] ?? 0;
        $validated['male_pembina_count'] = $request->male_pembina_count ?? 0;
        $validated['female_pembina_count'] = $request->female_pembina_count ?? 0;

        $validated['name'] = $request->pangkalan_name . ' (' . $request->gudep_number . ')';
        // Only update slug if name changed
        if ($gudep->pangkalan_name !== $request->pangkalan_name) {
            $validated['slug'] = Str::slug($request->pangkalan_name);
            $count = Gudep::where('slug', 'like', $validated['slug'].'%')->where('id', '!=', $gudep->id)->count();
            if($count > 0) $validated['slug'] .= '-' . ($count + 1);
        }

        if ($request->hasFile('logo')) {
            if ($gudep->logo) Storage::disk('public')->delete($gudep->logo);
            $validated['logo'] = $request->file('logo')->store('gudep', 'public');
        }
        if ($request->hasFile('hero_image')) {
            if ($gudep->hero_image) Storage::disk('public')->delete($gudep->hero_image);
            $validated['hero_image'] = $request->file('hero_image')->store('gudep', 'public');
        }

        // Handle Structure Photos
        $structure = $request->structure ?? [];
        if ($request->hasFile('structure_photos')) {
            foreach ($request->file('structure_photos') as $index => $photo) {
                if (isset($structure[$index])) {
                    // Delete old photo if exists
                    if (!empty($structure[$index]['old_photo'])) {
                        Storage::disk('public')->delete($structure[$index]['old_photo']);
                    }
                    $structure[$index]['photo'] = $photo->store('gudep/structure', 'public');
                }
            }
        }
        $validated['structure'] = $structure;

        // Handle Gallery Upload & Compression
        $gallery = $request->gallery ?? [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $index => $file) {
                $path = $file->store('gudep/gallery', 'public');
                $gallery[] = [
                    'image_path' => $path,
                    'caption' => $request->gallery_captions[$index] ?? ''
                ];
            }
        }
        $validated['gallery'] = $gallery;

        // Handle Videos
        $validated['videos'] = $request->videos ?? [];

        // Handle Achievements
        $validated['achievements'] = $request->achievements ?? [];

        // Handle Potensi
        $potensi = $request->potensi ?? [];
        $potensi = array_filter($potensi, function($item) {
            return !empty($item['jenjang']) && !empty($item['jumlah']);
        });
        $validated['potensi'] = array_values($potensi);

        // Handle Potensi Pembina
        $potensi_pembina = $request->potensi_pembina ?? [];
        $processed = [];
        foreach ($potensi_pembina as $entry) {
            if (empty($entry['jenis_kelamin']) || empty($entry['jumlah'])) continue;
            
            $kursus_data = [];
            $belum_kursus = !empty($entry['belum_kursus']) ? 1 : 0;
            
            if (!$belum_kursus && !empty($entry['kursus'])) {
                foreach ($entry['kursus'] as $jenis => $data) {
                    if (!empty($data['active']) && !empty($data['tahun'])) {
                        $kursus_data[] = [
                            'jenis' => $jenis,
                            'tahun' => (int)$data['tahun']
                        ];
                    }
                }
            }
            
            if ($belum_kursus || !empty($kursus_data)) {
                $processed[] = [
                    'jenis_kelamin' => $entry['jenis_kelamin'],
                    'jumlah' => $entry['jumlah'],
                    'belum_kursus' => $belum_kursus,
                    'kursus_data' => $kursus_data
                ];
            }
        }
        $validated['potensi_pembina'] = $processed;

        // Set default social media if empty
        $social = $request->social_media ?? [];
        if (empty($social['facebook'])) $social['facebook'] = \App\Models\Setting::get('social_facebook');
        if (empty($social['instagram'])) $social['instagram'] = \App\Models\Setting::get('social_instagram');
        if (empty($social['youtube'])) $social['youtube'] = \App\Models\Setting::get('social_youtube');
        if (empty($social['tiktok'])) $social['tiktok'] = \App\Models\Setting::get('social_tiktok');
        $validated['social_media'] = $social;

        $gudep->update($validated);

        return redirect()->route('admin.gudep.index')->with('success', 'Gudep berhasil diperbarui.');
    }

    public function destroy(Gudep $gudep)
    {
        $user = auth()->user();

        // Operator Gudep can ONLY delete their own Gudep
        if ($user->role === 'operator_gudep' && $gudep->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus data Gudep milik pangkalan lain.');
        }

        if ($gudep->logo) Storage::disk('public')->delete($gudep->logo);
        if ($gudep->hero_image) Storage::disk('public')->delete($gudep->hero_image);
        
        $gudep->delete();

        return redirect()->route('admin.gudep.index')->with('success', 'Gudep berhasil dihapus.');
    }
}
