<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        
        $featuredPost = Post::where('is_published', true)
            ->whereNotNull('featured_image')
            ->orderBy('published_at', 'desc')
            ->first();

        return view('posts.index', [
            'posts' => $posts,
            'featuredPost' => $featuredPost,
        ]);
    }
    
    public function show(Post $post)
    {
        if (!$post->is_published && !auth()->check()) {
            abort(404);
        }

        // Jalankan increment hanya jika dipublish
        if ($post->is_published) {
            $post->increment('views');
        }
        
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('is_published', true)
            ->take(3)
            ->get();
        
        return view('posts.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
