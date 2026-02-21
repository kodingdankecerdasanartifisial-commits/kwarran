<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('posts.submit', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $postData = [
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'excerpt' => $validated['excerpt'] ?? null,
            'category_id' => $validated['category_id'],
            'author' => $validated['name'] ?? 'Guest',
            'is_published' => false,
            'is_approved' => false,
            'submitted_via' => 'public',
            'submitter_name' => $validated['name'] ?? null,
            'submitter_email' => $validated['email'] ?? null,
        ];

        if ($request->hasFile('featured_image')) {
            $postData['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        Post::create($postData);

        return redirect()->route('posts.submit')->with('success', 'Terima kasih! Berita Anda telah dikirim dan menunggu proses review.');
    }
}
