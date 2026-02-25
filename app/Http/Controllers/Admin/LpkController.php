<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LpkController extends Controller
{
    public function dashboard()
    {
        return redirect()->route('admin.lpk.finances.index');
    }

    public function landingPage()
    {
        $lpk = Lpk::firstOrCreate(['slug' => 'lpk'], ['name' => 'Lembaga Pemeriksa Keuangan (LPK)']);
        return view('admin.lpk.landingpage', compact('lpk'));
    }

    public function updateLandingPage(Request $request)
    {
        $lpk = Lpk::firstOrCreate(['slug' => 'lpk']);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'social_media' => 'nullable|array',
            'videos' => 'nullable|array',
            'custom_html' => 'nullable|string',
            'structure' => 'nullable|array',
        ]);

        // Handle Logo
        if ($request->hasFile('logo')) {
            if ($lpk->logo) {
                Storage::delete($lpk->logo);
            }
            $validated['logo'] = $request->file('logo')->store('lpk', 'public');
        }

        // Handle Hero Image
        if ($request->hasFile('hero_image')) {
            if ($lpk->hero_image) {
                Storage::delete($lpk->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('lpk', 'public');
        }

        // Handle Structure Photos
        $structure = $request->input('structure', []);
        if ($request->hasFile('structure_photos')) {
            foreach ($request->file('structure_photos') as $index => $photo) {
                if (isset($structure[$index])) {
                    // Delete old photo if exists
                    if (!empty($structure[$index]['photo'])) {
                        Storage::delete($structure[$index]['photo']);
                    }
                    $path = $photo->store('lpk/structure', 'public');
                    $structure[$index]['photo'] = $path;
                }
            }
        }
        $validated['structure'] = $structure;

        $lpk->update($validated);

        return redirect()->back()->with('success', 'Landing page LPK berhasil diperbarui.');
    }

    public function agendas()
    {
        return view('admin.lpk.agendas');
    }

    public function posts()
    {
        $category = \App\Models\Category::where('name', 'LPK')->first();
        $posts = \App\Models\Post::where('category_id', $category?->id)->latest()->paginate(10);
        return view('admin.lpk.posts', compact('posts', 'category'));
    }
}