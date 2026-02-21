<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $keys = [
            'about',
            // Sidebar profile
            'sidebar_profile_name',
            'sidebar_profile_bio',
            'sidebar_profile_image',
            'sidebar_profile_link',
            'sidebar_popular_title',
            'social_facebook',
            'social_instagram',
            'social_youtube',
            'social_x',
            'social_tiktok',
            'address',
            'phone',
            'maps_embed',
            'email',
            'pic_web_link',
        ];

        $settings = [];
        foreach ($keys as $k) {
            $settings[$k] = Setting::get($k, '');
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'about' => 'nullable|string',
            'social_facebook' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_youtube' => 'nullable|url',
            'social_x' => 'nullable|url',
            'social_tiktok' => 'nullable|url',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'maps_embed' => 'nullable|string',
            'email' => 'nullable|email',
            'pic_web_link' => 'nullable|url',
            'sidebar_profile_name' => 'nullable|string',
            'sidebar_profile_bio' => 'nullable|string',
            'sidebar_profile_link' => 'nullable|url',
            'sidebar_popular_title' => 'nullable|string',
        ]);

        // Handle profile image upload separately
        if ($request->hasFile('sidebar_profile_image')) {
            $file = $request->file('sidebar_profile_image');
            $path = $file->store('sidebar', 'public');
            \App\Models\Setting::set('sidebar_profile_image', $path);
        }

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
