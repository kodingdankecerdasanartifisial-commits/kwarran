<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'post');
        $categories = Category::where('type', $type)->withCount('posts')->get();
        return view('admin.categories.index', compact('categories', 'type'));
    }

    public function create(Request $request)
    {
        $type = $request->get('type', 'post');
        return view('admin.categories.create', compact('type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories',
            'description' => 'nullable',
            'type' => 'required|in:post,materi',
        ]);

        $validated['slug'] = Str::slug($request->name);
        Category::create($validated);

        return redirect()->route('admin.categories.index', ['type' => $request->type])
            ->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $type = $category->type;
        return view('admin.categories.edit', compact('category', 'type'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable',
            'type' => 'required|in:post,materi',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $category->update($validated);

        return redirect()->route('admin.categories.index', ['type' => $request->type])
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki berita.');
        }
        
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
