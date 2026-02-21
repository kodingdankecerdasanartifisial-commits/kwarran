<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $isAgenda = $category->slug === 'agenda';
        
        if ($isAgenda) {
            $events = \App\Models\Event::where('is_active', true)
                ->orderBy('event_date', 'desc')
                ->paginate(10);
            
            return view('categories.show', [
                'category' => $category,
                'events' => $events,
                'isAgenda' => true,
            ]);
        }

        $posts = $category->posts()
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        
        return view('categories.show', [
            'category' => $category,
            'posts' => $posts,
            'isAgenda' => false,
        ]);
    }
}
