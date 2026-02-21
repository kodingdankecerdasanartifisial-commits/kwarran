<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Post::with('category')->orderBy('created_at', 'desc');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Exclude materi posts (those with PDF or YouTube)
        $query->whereNull('youtube_url')->whereNull('material_pdf');

        $posts = $query->paginate(10)->withQueryString();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function submissions()
    {
        $posts = Post::with('category')->where('submitted_via', 'public')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.posts.submissions', compact('posts'));
    }

    /**
     * Display only posts in the 'Pendidikan' or 'Materi' related categories.
     * Also support explicit 'materi' slug/category.
     */
    public function materi(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        
        // Materi are posts that have either a PDF or a YouTube link
        $query = Post::with('category')->where(function($q) {
            $q->whereNotNull('material_pdf')
              ->orWhereNotNull('youtube_url');
        })->orderBy('created_at', 'desc');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $posts = $query->paginate(10)->withQueryString();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create(Request $request)
    {
        $isMateri = $request->get('type') === 'materi';
        $selectedCategoryId = $request->get('category_id');
        
        if ($isMateri) {
            $categories = Category::where('name', 'like', 'Materi%')->get();
        } else {
            // regular posts usually exclude specific materi categories if needed, but for now allow all or filter out materi
            $categories = Category::where('name', 'not like', 'Materi%')->get();
        }

        return view('admin.posts.create', compact('categories', 'isMateri', 'selectedCategoryId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'material_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'youtube_url' => 'nullable|url',
        ]);

        // Generate SEO friendly slug
        $slug = Str::slug($request->title);
        if (strlen($slug) > 80) {
            $slug = substr($slug, 0, 80);
            // Ensure we don't end in half a word
            $slug = substr($slug, 0, strrpos($slug, '-'));
        }
        
        // Ensure uniqueness without using long timestamp
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $validated['slug'] = $slug;
        $validated['author'] = auth()->user()->name;
        $validated['is_published'] = $request->has('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($request->hasFile('material_pdf')) {
            $validated['material_pdf'] = $request->file('material_pdf')->store('materials', 'public');
        }

        $post = Post::create($validated);
        
        $type = $request->input('post_type');
        $redirectRoute = ($type === 'materi') ? route('admin.posts.materi') : route('admin.posts.index');
        
        // Redirect specifically for DKR if applicable
        $dkrCategory = Category::where('name', 'DKR')->first();
        if ($dkrCategory && $post->category_id == $dkrCategory->id) {
            $redirectRoute = route('admin.dkr.posts');
        }

        $message = ($type === 'materi') ? 'Materi berhasil ditambahkan.' : 'Berita berhasil diterbitkan.';

        return redirect($redirectRoute)->with('success', $message);
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,max:2048',
            'material_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'youtube_url' => 'nullable|url',
        ]);

        // Optional: Regenerate slug if title changes (optional, but good for SEO in early stages)
        if ($post->title !== $request->title) {
            $slug = Str::slug($request->title);
            if (strlen($slug) > 80) {
                $slug = substr($slug, 0, 80);
                $slug = substr($slug, 0, strrpos($slug, '-'));
            }
            
            $originalSlug = $slug;
            $count = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $post->slug = $slug;
        }

        if ($request->has('is_published') && !$post->is_published) {
            $post->published_at = now();
        }

        $post->is_published = $request->has('is_published');
        
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($post->featured_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($post->featured_image);
            }
            $post->featured_image = $request->file('featured_image')->store('posts', 'public');
        }

        if ($request->hasFile('material_pdf')) {
            if ($post->material_pdf && \Illuminate\Support\Facades\Storage::disk('public')->exists($post->material_pdf)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($post->material_pdf);
            }
            $post->material_pdf = $request->file('material_pdf')->store('materials', 'public');
        }

        $post->youtube_url = $request->youtube_url;

        $post->title = $validated['title'];
        $post->category_id = $validated['category_id'];
        $post->content = $validated['content'];
        $post->excerpt = $validated['excerpt'];
        $post->save();

        $redirectRoute = route('admin.posts.index');
        $dkrCategory = Category::where('name', 'DKR')->first();
        if ($dkrCategory && $post->category_id == $dkrCategory->id) {
            $redirectRoute = route('admin.dkr.posts');
        }

        return redirect($redirectRoute)->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'dkr') {
            return redirect()->back()->with('error', 'Hanya Admin atau Operator DKR yang dapat menghapus konten.');
        }

        $post->delete();
        
        $redirectRoute = route('admin.posts.index');
        $dkrCategory = Category::where('name', 'DKR')->first();
        if ($dkrCategory && $post->category_id == $dkrCategory->id) {
            $redirectRoute = route('admin.dkr.posts');
        }

        return redirect($redirectRoute)->with('success', 'Berita berhasil dihapus.');
    }
}
